<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::findOrFail($id);
        
        // Kategoriye ait makaleleri çek
        $articles = $category->articles()->with(['categories', 'user'])->latest()->get();
        
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }
}
