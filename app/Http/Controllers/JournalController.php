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

    /**
     * Tek bir derginin detaylarını ve sayılarını gösterir.
     */
    public function show(Journal $journal)
    {
        // Dergiyle birlikte sayılarını (issues) da yüklüyoruz
        $journal->load('issues');

        return view('journals.show', compact('journal'));
    }
}