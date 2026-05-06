<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    private function getMockCategories() {
        return collect([
            (object)['id' => 1, 'name' => 'Bilim'],
            (object)['id' => 2, 'name' => 'Spor'],
            (object)['id' => 3, 'name' => 'Sanat'],
        ]);
    }

    private function getMockArticles() {
        return collect([
            (object)[
                'id' => 1,
                'title' => 'Örnek Makale 1',
                'content' => 'Bu makale veritabanı olmadan oluşturulmuş örnek bir makaledir.',
                'user_id' => 1,
                'categories' => collect([(object)['name' => 'Bilim']]),
                'file_path' => null,
                'comments' => collect([])
            ],
            (object)[
                'id' => 2,
                'title' => 'İkinci Makale',
                'content' => 'Sistemdeki ikinci sahte makale.',
                'user_id' => 2,
                'categories' => collect([(object)['name' => 'Spor']]),
                'file_path' => null,
                'comments' => collect([
                    (object)['id' => 1, 'user_id' => 3, 'content' => 'Harika bir makale!']
                ])
            ],
        ]);
    }

    // Arama ve filtreleme özellikleri ile birlikte listeleme (Mock)
    public function index(Request $request)
    {
        $articles = $this->getMockArticles();

        // Arama işlemi
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $articles = $articles->filter(function($item) use ($searchTerm) {
                return stripos($item->title, $searchTerm) !== false || stripos($item->content, $searchTerm) !== false;
            });
        }

        $categories = $this->getMockCategories();

        return view('articles.index', compact('articles', 'categories'));
    }

    // Yeni makale oluşturma formu
    public function create()
    {
        $categories = $this->getMockCategories();
        return view('articles.create', compact('categories'));
    }

    // Makale kaydetme ve dosya yükleme işlemi (Simüle edilmiş)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $request->file('file')->store('articles', 'public');
        }

        return redirect()->route('articles.index')->with('success', 'Makale başarıyla yüklendi (Simülasyon).');
    }

    // Makale detay sayfası ve yorumlar
    public function show($id)
    {
        $article = $this->getMockArticles()->firstWhere('id', $id);
        if (!$article) {
            abort(404);
        }
        return view('articles.show', compact('article'));
    }

    // Makale dosyasını indirme işlemi
    public function download($id)
    {
        return redirect()->back()->with('error', 'Bu makale için dosya indirme özelliği şu an simülasyondur.');
    }

    // Makaleyi silme
    public function destroy($id)
    {
        return redirect()->route('articles.index')->with('success', 'Makale silindi (Simülasyon).');
    }
}
