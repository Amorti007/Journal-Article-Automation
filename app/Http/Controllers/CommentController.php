<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        return redirect()->route('articles.show', $articleId)->with('success', 'Yorum eklendi (Simülasyon).');
    }

    public function destroy($id)
    {
        return redirect()->back()->with('success', 'Yorum silindi (Simülasyon).');
    }
}
