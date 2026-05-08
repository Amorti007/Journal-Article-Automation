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
        // 1. Veriyi çekiyoruz (İlişkileriyle beraber çekmek performansı artırır)
        $journals = Journal::withCount('articles')->get();

        // 2. Eğer istek bir AJAX/JS isteği ise JSON döndür (Backend arkadaşın için)
        if ($request->wantsJson()) {
            return response()->json($journals);
        }

        // 3. Normal tarayıcı isteği ise View döndür (Frontend arkadaşın için)
        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        return view('journals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issn' => 'required|string|unique:journals,issn|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $journal = Journal::create($validated);

        return redirect()->route('journals.index')->with('success', 'Dergi başarıyla oluşturuldu.');
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