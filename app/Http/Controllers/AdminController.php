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
        // Tüm bekleyen makaleler: Bağımsız, Editör onayı bekleyen veya Admin onayı bekleyen
        $pendingArticles = Article::whereIn('status', ['pending', 'pending_journal_owner', 'pending_admin'])->with(['user', 'journal'])->get();
        
        $deleteRequests = Article::where('delete_requested', true)->with(['user', 'journal'])->get();

        $allJournals = Journal::with('user')->get();
        $allArticles = Article::where('status', 'approved')->with(['user', 'journal'])->get();
        $allComments = Comment::with(['user', 'article'])->get();

        return view('admin.dashboard', compact(
            'pendingJournals', 'pendingArticles', 'deleteRequests', 'allJournals', 'allArticles', 'allComments'
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
        // Reddedilen makale sistemden tamamen silinsin (Kullanıcının isteği üzerine)
        if ($article->pdf_path && file_exists(public_path($article->pdf_path))) {
            unlink(public_path($article->pdf_path));
        }
        $article->delete();
        return back()->with('success', 'Makale reddedildi ve sistemden silindi.');
    }

    public function cancelDeleteRequest(Article $article)
    {
        $article->update(['delete_requested' => false]);
        return back()->with('success', 'Silme isteği reddedildi, makale korundu.');
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
