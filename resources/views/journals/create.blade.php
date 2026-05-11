<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Dergi Ekle | MagReview</title>
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
                <h1>Yeni Dergi Ekle</h1>
                <p style="color: var(--text-secondary);">Yeni bir dergiyi platforma kaydedin.</p>
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

                <form action="{{ route('journals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="name">Dergi Adı</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Örn: Tech Advance Quarterly" required value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="issn">ISSN</label>
                        <input type="text" name="issn" id="issn" class="form-control" placeholder="Örn: 1234-5678" required value="{{ old('issn') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Kısa Açıklama</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Derginin içeriği ve amacı hakkında kısa bir bilgi verin...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kapak Fotoğrafı (İsteğe Bağlı)</label>
                            <div class="upload-area">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 1rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <div class="upload-text">Görseli sürükleyin veya <strong>bilgisayardan seçin</strong><br><small>(JPG, PNG - Max: 2MB)</small></div>
                                <input type="file" name="cover_image" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">Dergiyi Oluştur</button>
                    </div>

                </form>
            </div>
        </section>
    </main>

    @include('layouts.footer')

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
