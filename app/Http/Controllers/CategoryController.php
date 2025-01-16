<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        // dd($categories);
        return view('index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'panel_type' => 'required|string|max:255',
        ]);

        $category = Category::create($request->only('category_name', 'panel_type'));

        return response()->json([
            'newCategory' => [
                'category_name' => $category->category_name,
                'panel_type' => $category->panel_type,
            ]
        ]);
    }
}
