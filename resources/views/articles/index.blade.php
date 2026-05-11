<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tüm Makaleler | MagReview</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        .page-header {
            padding: 4rem 0 2rem;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .page-header p {
            color: var(--text-secondary);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        <!-- Page Header -->
        <section class="page-header container">
            <div class="animate-fade-in">
                <h1>Tüm Makaleler</h1>
                <p>Akademik dünyadan en güncel makaleleri okuyun, filtreleyin ve araştırmalarınıza katkı sağlayın.</p>
            </div>
        </section>

        <!-- Main Layout -->
        <section class="container">
            <!-- Content Area -->
            <div class="content-area animate-fade-in" style="animation-delay: 0.2s;">
                <div class="content-header">
                    <div>
                        <span style="color: var(--text-secondary); font-weight: 500;">{{ $articles->total() ?? $articles->count() }} Makale Bulundu</span>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <form action="{{ route('articles.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ara..." class="search-input" style="padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.5rem;">
                            
                            <select name="category_id" class="search-input" style="padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.5rem;">
                                <option value="">Tüm Kategoriler</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem;">Filtrele</button>
                        </form>
                        
                        <a href="{{ route('articles.create') }}" class="btn btn-primary" style="padding: 0.6rem 1.25rem;">+ Yeni Makale Ekle</a>
                    </div>
                </div>
                
                <div class="magazine-grid">
                    @forelse($articles as $article)
                        <article class="magazine-card">
                            @if($article->cover_image)
                                <img src="{{ Storage::url($article->cover_image) }}" alt="Makale Kapağı" class="magazine-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&q=80&w=800" alt="Makale Kapağı" class="magazine-image">
                            @endif
                            <div class="magazine-content">
                                <h3>{{ $article->title }}</h3>
                                <p>{{ Str::limit($article->abstract ?? 'Makale özeti bulunmuyor.', 120) }}</p>
                                
                                <div style="margin-bottom: 1rem;">
                                    @foreach($article->categories as $category)
                                        <span class="category-badge">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                                
                                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-outline" style="width: 100%">Makaleyi Oku</a>
                            </div>
                        </article>
                    @empty
                        <p style="color: var(--text-secondary);">Aradığınız kriterlere uygun makale bulunamadı.</p>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if(method_exists($articles, 'links'))
                    <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts.footer')

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
