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
        $baseArticles = collect([
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

        $dynamicMock = collect();
        if (Storage::disk('local')->exists('mock_articles.json')) {
            $saved = json_decode(Storage::disk('local')->get('mock_articles.json'), true);
            foreach($saved as $item) {
                $dynamicMock->push((object)[
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'content' => $item['content'],
                    'user_id' => $item['user_id'],
                    'categories' => collect([(object)['name' => 'Yüklenen Makale']]),
                    'file_path' => $item['file_path'],
                    'comments' => collect([])
                ]);
            }
        }

        return $baseArticles->merge($dynamicMock);
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

    // Makale kaydetme ve dosya yükleme işlemi
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                // Dosya adını benzersiz yapmak için time() ekliyoruz
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
                
                // public/makaleler dizinine taşıyoruz
                $file->move(public_path('makaleler'), $fileName);

                // Veritabanı tam hazır olmadığı için, bilgileri JSON'a kaydediyoruz
                $newArticle = [
                    'id' => time(),
                    'title' => $request->title,
                    'content' => $request->content,
                    'user_id' => auth()->id() ?? 1, // Eğer giriş yapılmamışsa varsayılan 1
                    'file_path' => 'makaleler/' . $fileName
                ];

                $existing = Storage::disk('local')->exists('mock_articles.json') 
                    ? json_decode(Storage::disk('local')->get('mock_articles.json'), true) 
                    : [];
                    
                $existing[] = $newArticle;
                Storage::disk('local')->put('mock_articles.json', json_encode($existing));
            }

            return redirect()->route('articles.index')->with('success', 'İçerik başarıyla yüklendi.');
        } catch (\Exception $e) {
            return back()->with('error', 'İçeriği yüklerken hatayla karşılaştık.')->withInput();
        }
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
        $article = $this->getMockArticles()->firstWhere('id', $id);
        if (!$article || !$article->file_path) {
            return redirect()->back()->with('error', 'Bu makale için indirilecek dosya bulunamadı.');
        }

        $filePath = public_path($article->file_path);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Dosya sunucuda bulunamadı.');
        }

        return response()->download($filePath);
    }

    // Makaleyi silme
    public function destroy($id)
    {
        return redirect()->route('articles.index')->with('success', 'Makale silindi (Simülasyon).');
    }
}
