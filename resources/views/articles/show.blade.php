<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} | MagReview</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        .article-hero {
            padding: 6rem 0 4rem;
            background: linear-gradient(to bottom, var(--bg-card), var(--bg-main));
            border-bottom: 1px solid var(--border);
            margin-bottom: 4rem;
        }
        .meta-info {
            display: flex;
            gap: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .article-content {
            background: var(--bg-card);
            padding: 3rem;
            border-radius: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            margin-bottom: 4rem;
        }
        .section-label {
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
            font-size: 0.75rem;
            margin-bottom: 1rem;
            display: block;
        }
        .comment-card {
            padding: 1.5rem;
            background: var(--bg-main);
            border-radius: 1rem;
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        <!-- Article Hero Section -->
        <section class="article-hero">
            <div class="container animate-fade-in">
                <div style="margin-bottom: 2rem;">
                    @foreach($article->categories as $category)
                        <span class="category-badge">{{ $category->name }}</span>
                    @endforeach
                </div>
                
                <h1 style="font-size: 3.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 2rem; color: var(--text-primary);">
                    {{ $article->title }}
                </h1>

                <div class="meta-info">
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>{{ $article->user->name ?? 'Yazar Bilinmiyor' }}</span>
                    </div>
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span>{{ $article->comments->count() }} Yorum</span>
                    </div>
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>{{ $article->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    @if($article->pdf_path)
                        <a href="{{ asset($article->pdf_path) }}" target="_blank" class="btn btn-primary">
                            <svg style="margin-right: 0.5rem" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Makaleyi Oku
                        </a>
                        <a href="{{ route('articles.download', $article->id) }}" class="btn btn-outline">
                            <svg style="margin-right: 0.5rem" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            PDF İndir
                        </a>
                    @endif
                    
                    @auth
                        @if(auth()->id() == $article->user_id || auth()->user()->isAdmin())
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline" style="border-color: #f39c12; color: #f39c12;">Düzenle</a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Emin misiniz?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="border-color: var(--accent); color: var(--accent);">Sil</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        <!-- Article Content -->
        <section class="container">
            <div class="article-content animate-fade-in" style="animation-delay: 0.2s;">
                <span class="section-label">Özet / Abstract</span>
                <p style="font-size: 1.125rem; line-height: 1.8; color: var(--text-primary); margin-bottom: 3rem;">
                    {{ $article->abstract }}
                </p>

                @if($article->journal)
                    <div style="padding: 2rem; background: var(--bg-main); border-radius: 1.5rem; border: 1px solid var(--border);">
                        <span class="section-label">Yayınlandığı Dergi</span>
                        <h4 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $article->journal->name }}</h4>
                        <a href="{{ route('journals.show', $article->journal->id) }}" style="color: var(--accent); font-weight: 600; text-decoration: none;">Dergi Detayına Git →</a>
                    </div>
                @endif
            </div>

            <!-- Comments Section -->
            <div class="animate-fade-in" style="animation-delay: 0.4s; margin-bottom: 8rem;">
                <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem;">Yorumlar</h3>
                
                @forelse($article->comments as $comment)
                    <div class="comment-card">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                            <strong style="color: var(--text-primary);">{{ $comment->user->name ?? 'Anonim' }}</strong>
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="color: var(--text-secondary);">{{ $comment->content }}</p>
                        
                        @auth
                            @if(auth()->id() == $comment->user_id || auth()->user()->isAdmin())
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="margin-top: 1rem;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: var(--accent); cursor: pointer; font-size: 0.875rem; font-weight: 600;">Yorumu Sil</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">Henüz yorum yapılmamış. İlk yorumu siz yapın!</p>
                @endforelse

                @auth
                    <div style="margin-top: 3rem;">
                        <h4 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Yorum Yap</h4>
                        <form action="{{ route('comments.store', $article->id) }}" method="POST">
                            @csrf
                            <textarea name="content" rows="4" style="width: 100%; padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-primary); margin-bottom: 1rem; outline: none; transition: border-color 0.2s;" placeholder="Düşüncelerinizi paylaşın..." required></textarea>
                            <button type="submit" class="btn btn-primary">Gönder</button>
                        </form>
                    </div>
                @else
                    <div style="padding: 2rem; background: var(--bg-main); border-radius: 1.5rem; text-align: center; margin-top: 3rem;">
                        <p style="color: var(--text-secondary);">Yorum yapmak için lütfen <a href="{{ route('login') }}" style="color: var(--accent); font-weight: 700;">giriş yapın</a>.</p>
                    </div>
                @endauth
            </div>
        </section>
    </main>

    @include('layouts.footer')
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
