<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Models\score;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Loader\Configurator\ImportConfigurator;

class QuestionnaireController extends Controller
{
    public function index()
    {
        // Fetch questions with their scores
        $questions = Question::with('score')->get();
        return view('list', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'options' => 'required|array',
            'options.*' => 'required|string|max:255',
            'score' => 'required|array',
            'score.*' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {
            // Create a new question
            $question = Question::create([
                'category_id' => $request->category_id,
                'question_txt' => $request->question,
                'question_type' => implode(', ', $request->options),
                'score_value' => implode(',', $request->score),
            ]);

            // Save options and scores
            foreach ($request->options as $index => $option) {
                Score::create([
                    'question_id' => $question->id,
                    'score' => $request->score[$index],
                ]);
            }

            DB::commit();

            return redirect()->route('questions')->with('success', 'Question added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to add question.');
        }
    }
}
