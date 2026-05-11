<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagReview | Akademik Bilgiye Hızlı ve Güvenilir Erişim</title>
    <meta name="description" content="Akademik dergileri inceleyin, makalelere göz atın ve akademik dünyaya katkıda bulunun.">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    @include('layouts.header')

    <main>
        <!-- 1. Hero Section -->
        <section class="hero container">
            <div class="animate-fade-in">
                <h1>Akademik Bilgiye Hızlı ve <br> Güvenilir Erişim.</h1>
                <p>Dergileri inceleyin, makalelere göz atın ve akademik dünyaya katkıda bulunun.</p>
                <div class="hero-btns">
                    <a href="{{ route('register') }}" class="btn btn-primary" id="mainActionBtn">Hemen Kayıt Ol</a>
                    <a href="{{ route('journals.index') }}" class="btn btn-outline">Daha Fazla Bilgi</a>
                </div>
            </div>
        </section>

        <!-- 2. Stats Panel -->
        <section class="container">
            <div class="stats-panel">
                <div class="stat-item">
                    <span class="stat-number">{{ $totalArticles }}</span>
                    <span class="stat-label">Toplam Makale</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalJournals }}</span>
                    <span class="stat-label">Aktif Dergiler</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalAuthors }}</span>
                    <span class="stat-label">Yazar Sayısı</span>
                </div>
            </div>
        </section>


        <!-- 3. Featured Magazines -->
        <section class="container" style="margin-bottom: 8rem;">
            <div class="section-title">
                <h2>Öne Çıkan Dergiler</h2>
                <a href="{{ route('journals.index') }}" class="nav-link" style="color: var(--accent); font-weight: 700">Tümünü Gör →</a>
            </div>
            <div class="magazine-grid">
                @forelse($featuredJournals as $journal)
                <article class="magazine-card">
                    @if($journal->cover_image)
                        <img src="{{ Storage::url($journal->cover_image) }}" alt="Dergi Kapağı" class="magazine-image">
                    @else
                        <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                    @endif
                    <div class="magazine-content">
                        <h3>{{ $journal->name }}</h3>
                        <p>{{ Str::limit($journal->description ?? 'Dergi açıklaması bulunmamaktadır.', 100) }}</p>
                        <a href="{{ route('journals.show', $journal->id) }}" class="btn btn-outline" style="width: 100%">İncele</a>
                    </div>
                </article>
                @empty
                <p style="color: var(--text-secondary);">Henüz öne çıkan dergi bulunmamaktadır.</p>
                @endforelse
            </div>
        </section>

        <!-- 5. How It Works -->
        <section class="container how-it-works">
            <h2 style="font-size: 2.25rem; margin-bottom: 1rem;">Nasıl Çalışır?</h2>
            <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto 4rem;">Sistemi kullanmaya başlamak için 3 basit adım.</p>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h4>Göz At</h4>
                    <p>Dergileri ve makaleleri inceleyerek ilgi alanınıza uygun çalışmaları keşfedin.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h4>Yükle</h4>
                    <p>Kendi akademik çalışmanızı sisteme dahil edin ve geniş bir kitleye ulaştırın.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h4>Değerlendir</h4>
                    <p>Makaleler hakkında geri bildirim alın ve diğer çalışmalarla etkileşime geçin.</p>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
