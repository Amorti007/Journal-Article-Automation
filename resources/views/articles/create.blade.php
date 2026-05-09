<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Makale Ekle | MagReview</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        .page-header {
            padding: 4rem 0 2rem;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .form-container {
            max-width: 800px;
            margin: 0 auto 6rem;
            background-color: var(--bg-card);
            border-radius: 1.5rem;
            padding: 3rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
            background-color: var(--bg-main);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .upload-area {
            border: 2px dashed var(--border);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            background-color: var(--bg-main);
            transition: all 0.2s;
            position: relative;
        }

        .upload-area input[type="file"] {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: var(--accent);
            background-color: var(--accent-soft);
        }

        .upload-icon {
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .upload-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .upload-text strong {
            color: var(--accent);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .form-container {
                padding: 1.5rem;
            }
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        <!-- Page Header -->
        <section class="page-header container">
            <div class="animate-fade-in">
                <h1>Yeni Makale Ekle</h1>
                <p style="color: var(--text-secondary);">Akademik araştırmanızı platformumuza yükleyerek geniş kitlelere ulaştırın.</p>
            </div>
        </section>

        <!-- Upload Form -->
        <section class="container">
            <div class="form-container animate-fade-in" style="animation-delay: 0.1s;">
                
                @if($errors->any())
                    <div class="alert-error">
                        <ul style="margin-left: 1.5rem; list-style-type: disc;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="journal_id">Gönderilecek Dergi</label>
                        <select name="journal_id" id="journal_id" class="form-control">
                            <option value="">-- Bağımsız Makale --</option>
                            @foreach($journals as $journal)
                                <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="title">Makale Başlığı</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Örn: Yapay Zeka Algoritmalarının Eğitimi..." required value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="categories">Kategoriler (Birden fazla seçmek için CTRL/CMD basılı tutun)</label>
                        <select name="categories[]" id="categories" class="form-control" multiple required style="min-height: 100px;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="abstract">Makale Özeti (Abstract)</label>
                        <textarea name="abstract" id="abstract" class="form-control" placeholder="Makalenizin temel bulguları ve amacı hakkında kısa bir bilgi verin..." required>{{ old('abstract') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Makale Dosyası (Zorunlu)</label>
                        <div class="upload-area">
                            <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 1rem;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                            <div class="upload-text">Dosyayı sürükleyin veya <strong>bilgisayardan seçin</strong><br><small>(PDF, DOC, DOCX - Max: 10MB)</small></div>
                            <input type="file" name="file" accept=".pdf,.doc,.docx" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">Makaleyi Yükle ve Onaya Gönder</button>
                    </div>

                </form>
            </div>
        </section>
    </main>

    @include('layouts.footer')

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
