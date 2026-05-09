<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Article;
use App\Models\Comment;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Sadece adminler bu alana erişebilir.');
        }

        $pendingJournals = Journal::where('status', 'pending')->with('user')->get();
        // independent pending articles or articles approved by journal owner but pending admin
        $pendingArticles = Article::where('status', 'pending_admin')->orWhere('status', 'pending')->with(['user', 'journal'])->get();
        
        $allJournals = Journal::with('user')->get();
        $allArticles = Article::with(['user', 'journal'])->get();
        $allComments = Comment::with(['user', 'article'])->get();

        return view('admin.dashboard', compact(
            'pendingJournals', 'pendingArticles', 'allJournals', 'allArticles', 'allComments'
        ));
    }

    public function approveJournal(Journal $journal)
    {
        $journal->update(['status' => 'approved']);
        return back()->with('success', 'Dergi onaylandı.');
    }

    public function rejectJournal(Journal $journal)
    {
        $journal->update(['status' => 'rejected']);
        return back()->with('success', 'Dergi reddedildi.');
    }

    public function deleteJournal(Journal $journal)
    {
        $journal->delete();
        return back()->with('success', 'Dergi silindi.');
    }

    public function approveArticle(Article $article)
    {
        $article->update(['status' => 'approved']);
        return back()->with('success', 'Makale onaylandı.');
    }

    public function rejectArticle(Article $article)
    {
        $article->update(['status' => 'rejected']);
        return back()->with('success', 'Makale reddedildi.');
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Makale silindi.');
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Yorum silindi.');
    }
}
