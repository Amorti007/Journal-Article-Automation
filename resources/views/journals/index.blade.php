<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tüm Dergiler | MagReview</title>
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
                <h1>Tüm Dergiler</h1>
                <p>Akademik dünyadan en son dergileri inceleyin, filtreleyin ve dilediğinizi okumaya başlayın.</p>
            </div>
        </section>

        <!-- Main Layout -->
        <section class="container">
            <!-- Content Area -->
            <div class="content-area animate-fade-in" style="animation-delay: 0.2s;">
                <div class="content-header">
                    <div>
                        <span style="color: var(--text-secondary); font-weight: 500;">{{ $journals->total() ?? $journals->count() }} Dergi Bulundu</span>
                    </div>
                    <div>
                        @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                            <a href="{{ route('journals.create') }}" class="btn btn-primary" style="padding: 0.6rem 1.25rem;">+ Yeni Dergi Ekle</a>
                            <a href="{{ route('issues.create') }}" class="btn btn-outline" style="padding: 0.6rem 1.25rem;">+ Yeni Sayı</a>
                        @endif
                        @endauth
                    </div>
                </div>
                
                <div class="magazine-grid">
                    @forelse($journals as $journal)
                        <article class="magazine-card">
                            @if($journal->cover_image)
                                <img src="{{ Storage::url($journal->cover_image) }}" alt="Dergi Kapağı" class="magazine-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                            @endif
                            <div class="magazine-content">
                                <h3>{{ $journal->name }}</h3>
                                <p>{{ Str::limit($journal->description ?? 'Açıklama bulunmuyor.', 100) }}</p>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.875rem;">
                                    <span style="color: var(--text-secondary);">ISSN: {{ $journal->issn }}</span>
                                    <span style="color: var(--accent); font-weight: 600;">{{ $journal->articles_count ?? 0 }} Makale</span>
                                </div>
                                <a href="{{ route('journals.show', $journal->id) }}" class="btn btn-outline" style="width: 100%">İncele</a>
                            </div>
                        </article>
                    @empty
                        <p style="color: var(--text-secondary);">Henüz sistemde dergi bulunmamaktadır.</p>
                    @endforelse
                </div>
                
                @if(method_exists($journals, 'links'))
                    <div style="margin-top: 3rem;">
                        {{ $journals->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts.footer')

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>