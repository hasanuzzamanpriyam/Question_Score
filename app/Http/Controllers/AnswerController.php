<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\answer;
use App\Models\question;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = answer::all();
        return view('answers', compact('answers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'answer' => 'required|array',
            'answer.*.option' => 'required|string',
            'answer.*.score' => 'required|integer',
        ]);

        $user = Auth::user();

        foreach ($request->answer as $questionId => $ansData) {
            if (!empty($ansData)) {
                $answer = new answer();
                $answer->user_id = $user->id;
                $answer->answer_txt = $ansData['option'];
                $answer->answer_score = $ansData['score'];
                $answer->question_id = $questionId;
                $answer->category_id = question::find($questionId)->category_id;
                $answer->save();
            }
        }

        return redirect()->route('show_answers');
    }
}
