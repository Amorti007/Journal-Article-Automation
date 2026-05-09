<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tüm Dergiler | MagReview</title>
    <link rel="stylesheet" href="style.css">
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
        
        .layout-with-sidebar {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 3rem;
            margin-bottom: 6rem;
        }
        
        .sidebar {
            background-color: var(--bg-card);
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            padding: 2rem;
            height: fit-content;
            position: sticky;
            top: 6rem;
        }
        
        .filter-group {
            margin-bottom: 2rem;
        }
        
        .filter-group:last-child {
            margin-bottom: 0;
        }
        
        .filter-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }
        
        .filter-list {
            list-style: none;
        }
        
        .filter-list li {
            margin-bottom: 0.75rem;
        }
        
        .filter-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .filter-label:hover {
            color: var(--accent);
        }
        
        .filter-checkbox {
            width: 1.125rem;
            height: 1.125rem;
            accent-color: var(--accent);
            cursor: pointer;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        @media (max-width: 992px) {
            .layout-with-sidebar {
                grid-template-columns: 1fr;
            }
            .sidebar {
                position: static;
            }
        }
    </style>
</head>
<body>
    <!-- Header Placeholder -->
    <div id="header-placeholder"></div>

    <main>
        <!-- Page Header -->
        <section class="page-header container">
            <div class="animate-fade-in">
                <h1>Tüm Dergiler</h1>
                <p>Akademik dünyadan en son dergileri inceleyin, filtreleyin ve dilediğinizi okumaya başlayın.</p>
            </div>
        </section>

        <!-- Main Layout -->
        <section class="container layout-with-sidebar">
            <!-- Sidebar / Filters -->
            <aside class="sidebar animate-fade-in" style="animation-delay: 0.1s;">
                <div class="filter-group">
                    <h3 class="filter-title">Kategoriler</h3>
                    <ul class="filter-list">
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox" checked> Tüm Kategoriler</label></li>
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox"> Mühendislik</label></li>
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox"> Sosyal Bilimler</label></li>
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox"> Fen Bilimleri</label></li>
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox"> Tıp & Sağlık</label></li>
                    </ul>
                </div>
                
                <div class="filter-group">
                    <h3 class="filter-title">Yayın Dili</h3>
                    <ul class="filter-list">
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox"> Türkçe</label></li>
                        <li><label class="filter-label"><input type="checkbox" class="filter-checkbox"> İngilizce</label></li>
                    </ul>
                </div>
                
                <button class="btn btn-outline" style="width: 100%; margin-top: 1rem;">Filtreleri Uygula</button>
            </aside>

            <!-- Content Area -->
            <div class="content-area animate-fade-in" style="animation-delay: 0.2s;">
                <div class="content-header">
                    <div>
                        <span style="color: var(--text-secondary); font-weight: 500;">480 Dergi Bulundu</span>
                    </div>
                    <div>
                        <a href="dergi-ekle.html" class="btn btn-primary" style="padding: 0.6rem 1.25rem;">+ Yeni Dergi Ekle</a>
                    </div>
                </div>
                
                <div class="magazine-grid">
                    <!-- Magazine 1 -->
                    <article class="magazine-card">
                        <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                        <div class="magazine-content">
                            <h3>Tech Advance Quarterly</h3>
                            <p>Yapay zeka ve robotik alanındaki en son araştırmaları ve teknik makaleleri içeren hakemli dergi.</p>
                            <a href="#" class="btn btn-outline" style="width: 100%">İncele</a>
                        </div>
                    </article>

                    <!-- Magazine 2 -->
                    <article class="magazine-card">
                        <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                        <div class="magazine-content">
                            <h3>Global Society Review</h3>
                            <p>Sosyoloji, antropoloji ve kültürel çalışmalar üzerine derinlemesine analizler ve saha araştırmaları.</p>
                            <a href="#" class="btn btn-outline" style="width: 100%">İncele</a>
                        </div>
                    </article>

                    <!-- Magazine 3 -->
                    <article class="magazine-card">
                        <img src="https://images.unsplash.com/photo-1505751172107-59725a27377e?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                        <div class="magazine-content">
                            <h3>Nature & Discovery</h3>
                            <p>Biyoloji, ekoloji ve çevre bilimleri alanında çığır açan keşiflerin paylaşıldığı akademik platform.</p>
                            <a href="#" class="btn btn-outline" style="width: 100%">İncele</a>
                        </div>
                    </article>
                    
                    <!-- Magazine 4 -->
                    <article class="magazine-card">
                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                        <div class="magazine-content">
                            <h3>Medical Horizons</h3>
                            <p>Modern tıp uygulamaları, klinik bulgular ve sağlık bilimleri üzerine uluslararası hakemli dergi.</p>
                            <a href="#" class="btn btn-outline" style="width: 100%">İncele</a>
                        </div>
                    </article>
                    
                    <!-- Magazine 5 -->
                    <article class="magazine-card">
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800" alt="Dergi Kapağı" class="magazine-image">
                        <div class="magazine-content">
                            <h3>Hardware Innovation</h3>
                            <p>Donanım mimarisi ve gömülü sistemler üzerine yenilikçi yaklaşımlar ve teknik raporlar.</p>
                            <a href="#" class="btn btn-outline" style="width: 100%">İncele</a>
                        </div>
                    </article>
                </div>
                
                <!-- Pagination -->
                <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
                    <a href="#" class="btn btn-primary" style="padding: 0.5rem 1rem;">1</a>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">2</a>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">3</a>
                    <a href="#" class="btn btn-outline" style="padding: 0.5rem 1rem;">İleri</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <script src="script.js"></script>
</body>
</html>
