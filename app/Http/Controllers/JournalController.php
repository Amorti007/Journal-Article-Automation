<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Dergi kataloğunu listeler.
     * Bu metod, hem Blade hem de JS (Ajax) tarafı için 'beyin' görevi görür.
     */
    public function index(Request $request)
    {
        $query = Journal::where('status', 'approved')->withCount('articles');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('issn', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $journals = $query->paginate(12);

        if ($request->wantsJson()) {
            return response()->json($journals);
        }

        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        if (auth()->user()->role === 'reader') {
            abort(403, 'Okur hesabı ile dergi oluşturulamaz.');
        }
        return view('journals.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'reader') {
            abort(403, 'Okur hesabı ile dergi oluşturulamaz.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issn' => 'required|string|unique:journals,issn|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $validated['user_id'] = auth()->id() ?? 1;
        $validated['status'] = 'pending';

        $journal = Journal::create($validated);
        
        if (auth()->user()->isEditor()) {
            return redirect()->route('editor.dashboard')->with('success', 'Dergi başarıyla oluşturuldu ve onaya gönderildi.');
        }

        return redirect()->route('journals.index')->with('success', 'Dergi başarıyla oluşturuldu ve onaya gönderildi.');
    }

    /**
     * Tek bir derginin detaylarını ve sayılarını gösterir.
     */
    public function show(Journal $journal)
    {
        // Dergiyle birlikte sayılarını (issues) ve bu sayıların içindeki makaleleri (articles) yüklüyoruz.
        $journal->load(['issues.articles']);

        // Erken görünümde olan, yani henüz bir sayıya atanmamış makaleleri ayrıca alıyoruz.
        $unassignedArticles = $journal->articles()->whereNull('issue_id')->get();

        return view('journals.show', compact('journal', 'unassignedArticles'));
    }

    public function destroy(Journal $journal)
    {
        // Dergiye ait kapak resmi vs varsa silinebilir (ileride)
        $journal->delete();
        return redirect()->route('journals.index')->with('success', 'Dergi başarıyla silindi.');
    }
}