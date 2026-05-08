<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Journal;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function create()
    {
        $journals = Journal::all();
        return view('issues.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'volume' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
        ]);

        $issue = Issue::create($validated);

        return redirect()->route('journals.show', $issue->journal_id)
            ->with('success', 'Sayı (Issue) başarıyla oluşturuldu.');
    }
}
