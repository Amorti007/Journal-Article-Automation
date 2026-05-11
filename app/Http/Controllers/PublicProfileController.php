<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show($id)
    {
        $user = User::with([
            'journals' => function($query) {
                $query->where('status', 'approved')->withCount('articles');
            },
            'articles' => function($query) {
                $query->where('status', 'approved')->with('journal');
            },
            'comments.article'
        ])->findOrFail($id);

        return view('profile.show', compact('user'));
    }
}
