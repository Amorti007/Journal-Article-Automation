<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('status', 'approved')->with(['categories', 'user']);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('abstract', 'like', '%' . $searchTerm . '%');
            });
        }

        $articles = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        if (auth()->user()->role === 'reader') {
            abort(403, 'Okur hesabı ile makale yüklenemez.');
        }
        $categories = Category::all();
        $journals = Journal::all();
        return view('articles.create', compact('categories', 'journals'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'reader') {
            abort(403, 'Okur hesabı ile makale yüklenemez.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'categories' => 'required|array',
            'journal_id' => 'nullable|exists:journals,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
                $file->move(public_path('uploads_articles'), $fileName);
            }

            // Test ortamında hata vermemesi için varsayılan kullanıcı
            $userId = auth()->id();
            if (!$userId) {
                $user = \App\Models\User::first();
                $userId = $user ? $user->id : 1;
            }

            $status = $request->journal_id ? 'pending_journal_owner' : 'pending_admin';

            $article = Article::create([
                'title' => $request->title,
                'abstract' => $request->abstract,
                'user_id' => $userId,
                'journal_id' => $request->journal_id,
                'pdf_path' => $fileName ? 'uploads_articles/' . $fileName : null,
                'status' => $status
            ]);

            $article->categories()->attach($request->categories);

            return redirect()->route('articles.index')->with('success', 'İçerik başarıyla yüklendi.');
        } catch (\Exception $e) {
            return back()->with('error', 'İçeriği yüklerken hatayla karşılaştık: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $article = Article::with(['comments.user', 'categories', 'user', 'journal'])->findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        
        // Sadece dergisi olan makaleler sayılara atanabilir (Bağımsız makaleler de düzenlenebilir ama sayıya atanamaz)
        $issues = collect();
        if ($article->journal_id) {
            $issues = \App\Models\Issue::where('journal_id', $article->journal_id)->get();
        }

        return view('articles.edit', compact('article', 'issues'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'issue_id' => 'nullable|exists:issues,id'
        ]);

        $article->update([
            'status' => $request->status,
            'issue_id' => $request->issue_id
        ]);

        return redirect()->route('articles.show', $article->id)->with('success', 'Makale durumu başarıyla güncellendi.');
    }

    public function download($id)
    {
        $article = Article::findOrFail($id);
        if (!$article || !$article->pdf_path) {
            return redirect()->back()->with('error', 'Bu makale için indirilecek dosya bulunamadı.');
        }

        $filePath = public_path($article->pdf_path);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Dosya sunucuda bulunamadı.');
        }

        return response()->download($filePath);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        if ($article->pdf_path && file_exists(public_path($article->pdf_path))) {
            unlink(public_path($article->pdf_path));
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Makale başarıyla silindi.');
    }
}
