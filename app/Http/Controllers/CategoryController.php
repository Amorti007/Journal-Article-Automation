<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
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
                'categories' => collect([(object)['id' => 1, 'name' => 'Bilim']]),
                'file_path' => null,
                'comments' => collect([])
            ],
            (object)[
                'id' => 2,
                'title' => 'İkinci Makale',
                'content' => 'Sistemdeki ikinci sahte makale.',
                'user_id' => 2,
                'categories' => collect([(object)['id' => 2, 'name' => 'Spor']]),
                'file_path' => null,
                'comments' => collect([
                    (object)['id' => 1, 'user_id' => 3, 'content' => 'Harika bir makale!']
                ])
            ],
        ]);
    }

    public function show($id)
    {
        $categories = $this->getMockCategories();
        $category = $categories->firstWhere('id', $id);
        
        if (!$category) abort(404);

        $articles = $this->getMockArticles()->filter(function($article) use ($id) {
            return $article->categories->contains('id', $id);
        });
        
        return view('articles.index', compact('articles', 'categories'));
    }
}

