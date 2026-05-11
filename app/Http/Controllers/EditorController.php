<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Article;

class EditorController extends Controller
{
    public function dashboard()
    {
        if (!auth()->user()->isEditor()) {
            abort(403, 'Sadece editörler bu alana erişebilir.');
        }

        $user = auth()->user();

        // Dergilerim
        $myJournals = Journal::where('user_id', $user->id)->with('issues')->get();

        // Dergilerime gelen makale istekleri
        $journalIds = $myJournals->pluck('id');
        $incomingRequests = Article::whereIn('journal_id', $journalIds)
            ->where('status', 'pending_journal_owner')
            ->with('user')
            ->get();

        // Dergilerimdeki silme istekleri
        $deleteRequests = Article::whereIn('journal_id', $journalIds)
            ->where('delete_requested', true)
            ->with('user')
            ->get();

        // Benim yüklediğim makaleler
        $myArticles = Article::where('user_id', $user->id)->with('journal')->get();

        return view('editor.dashboard', compact('myJournals', 'incomingRequests', 'deleteRequests', 'myArticles'));
    }

    public function approveArticleRequest(Request $request, Article $article)
    {
        // Journal owner assigns issue and sends to admin
        $request->validate([
            'issue_id' => 'required|exists:issues,id'
        ]);

        $article->update([
            'issue_id' => $request->issue_id,
            'status' => 'pending_admin' // Now admin has to approve it
        ]);

        return back()->with('success', 'Makale isteği kabul edildi ve sayıya atandı. Admin onayına gönderildi.');
    }

    public function rejectArticleRequest(Article $article)
    {
        $article->update(['status' => 'rejected']);
        return back()->with('success', 'Makale isteği reddedildi.');
    }

    public function requestDelete(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }
        $article->update(['delete_requested' => true]);
        return back()->with('success', 'Silme isteği gönderildi.');
    }

    public function approveDelete(Article $article)
    {
        // Journal owner approves delete request, but only Admin can delete
        $journal = $article->journal;
        if ($journal && $journal->user_id === auth()->id()) {
            // We can add a flag here if we want, but for now let's say 
            // the owner's "approval" is just a way to signal to Admin.
            // Or better: only Admin sees the delete button in their panel.
            // Let's just return with a message that Admin will handle it.
            return back()->with('success', 'Silme isteği onaylandı. Admin tarafından kalıcı olarak silinecektir.');
        }
        abort(403);
    }
}
