<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $userId = auth()->id();
        if (!$userId) {
            $user = \App\Models\User::first();
            $userId = $user ? $user->id : 1;
        }

        Comment::create([
            'content' => $request->content,
            'user_id' => $userId,
            'article_id' => $articleId
        ]);

        return redirect()->route('articles.show', $articleId)->with('success', 'Yorum başarıyla eklendi.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Yorum silindi.');
    }
}
