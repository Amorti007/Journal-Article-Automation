<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $journal->name }} | MagReview</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .journal-hero {
            padding: 6rem 0 4rem;
            background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-main) 100%);
            border-bottom: 1px solid var(--border);
            margin-bottom: 4rem;
        }
        .journal-card {
            background: var(--bg-card);
            border-radius: 2rem;
            border: 1px solid var(--border);
            padding: 3rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 3rem;
        }
        .issue-accordion {
            background: var(--bg-card);
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s;
        }
        .issue-accordion:hover {
            border-color: var(--accent);
        }
        .issue-trigger {
            width: 100%;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            outline: none;
        }
        .article-item {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border);
            transition: background-color 0.2s;
        }
        .article-item:hover {
            background-color: var(--bg-main);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        <!-- Journal Hero Section -->
        <section class="journal-hero">
            <div class="container animate-fade-in">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <span class="category-badge">Akademik Dergi</span>
                        <h1 style="font-size: 3.5rem; font-weight: 800; color: var(--text-primary); margin: 1rem 0;">{{ $journal->name }}</h1>
                        <div style="color: var(--text-secondary); font-weight: 600;">ISSN: {{ $journal->issn }}</div>
                    </div>
                    
                    @auth
                        @if(auth()->id() == $journal->user_id || auth()->user()->isAdmin())
                            <div style="display: flex; gap: 1rem;">
                                <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" onsubmit="return confirm('Emin misiniz?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="border-color: var(--accent); color: var(--accent);">Dergiyi Sil</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="journal-card">
                    <p style="font-size: 1.125rem; line-height: 1.8; color: var(--text-secondary); margin: 0;">
                        {{ $journal->description ?? 'Bu dergi için bir açıklama bulunmuyor.' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Issues and Articles Section -->
        <section class="container" style="margin-bottom: 8rem;">
            <h2 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 3rem; color: var(--text-primary);">Sayılar ve Makaleler</h2>

            <div class="animate-fade-in" style="animation-delay: 0.2s;">
                @forelse($journal->issues as $issue)
                    <div class="issue-accordion" x-data="{ open: false }">
                        <button class="issue-trigger" @click="open = !open">
                            <div>
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
                                    {{ $issue->year }} - Cilt {{ $issue->volume ?? '?' }}, Sayı {{ $issue->number }}
                                </h3>
                                <span style="font-size: 0.875rem; color: var(--text-secondary);">{{ $issue->articles->count() }} Makale</span>
                            </div>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transition: transform 0.3s;" :style="open ? 'transform: rotate(180deg)' : ''"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        
                        <div x-show="open" x-cloak x-transition>
                            @foreach($issue->articles as $article)
                                <div class="article-item">
                                    <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">
                                        <a href="{{ route('articles.show', $article->id) }}" style="color: var(--text-primary); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-primary)'">
                                            {{ $article->title }}
                                        </a>
                                    </h4>
                                    <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">
                                        {{ Str::limit($article->abstract, 150) }}
                                    </p>
                                    <div style="display: flex; gap: 1rem;">
                                        <a href="{{ route('articles.show', $article->id) }}" style="font-size: 0.875rem; color: var(--accent); font-weight: 700; text-decoration: none;">İncele →</a>
                                        @if($article->pdf_path)
                                            <a href="{{ route('articles.download', $article->id) }}" style="font-size: 0.875rem; color: var(--text-secondary); text-decoration: none;">PDF İndir</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div style="padding: 4rem; background: var(--bg-card); border-radius: 2rem; border: 1px dashed var(--border); text-align: center;">
                        <p style="color: var(--text-secondary);">Bu dergiye ait henüz yayınlanmış bir sayı bulunmuyor.</p>
                    </div>
                @endforelse

                <!-- Unassigned Articles -->
                @if($unassignedArticles->count() > 0)
                    <div style="margin-top: 4rem;">
                        <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 2rem; color: var(--text-primary);">Sayı Bekleyen Makaleler (Erken Görünüm)</h3>
                        <div class="journal-card" style="padding: 0; overflow: hidden;">
                            @foreach($unassignedArticles as $article)
                                <div class="article-item">
                                    <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">
                                        <a href="{{ route('articles.show', $article->id) }}" style="color: var(--text-primary); text-decoration: none;">
                                            {{ $article->title }}
                                        </a>
                                    </h4>
                                    <p style="font-size: 0.875rem; color: var(--text-secondary);">{{ Str::limit($article->abstract, 150) }}</p>
                                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                                        <a href="{{ route('articles.show', $article->id) }}" style="font-size: 0.875rem; color: var(--accent); font-weight: 700; text-decoration: none;">İncele →</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts.footer')
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
