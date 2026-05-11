<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makale Düzenle | MagReview</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        .edit-container {
            max-width: 800px;
            margin: 6rem auto 8rem;
            background: var(--bg-card);
            padding: 3rem;
            border-radius: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
        }
        .form-group {
            margin-bottom: 2rem;
        }
        .form-label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
            font-size: 0.9375rem;
        }
        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            border: 1px solid var(--border);
            background: var(--bg-main);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-soft);
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <main class="container">
        <div class="edit-container animate-fade-in">
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('articles.show', $article->id) }}" style="color: var(--text-secondary); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Makaleye Dön
                </a>
            </div>

            <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.5rem;">Makaleyi Düzenle</h1>
            <p style="color: var(--text-secondary); margin-bottom: 3rem;">{{ $article->title }}</p>

            <form action="{{ route('articles.update', $article->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label" for="status">Yayın Durumu</label>
                    <select id="status" name="status" required class="form-control">
                        <option value="pending" {{ $article->status == 'pending' ? 'selected' : '' }}>Onay Bekliyor</option>
                        <option value="approved" {{ $article->status == 'approved' ? 'selected' : '' }}>Onaylandı (Yayında)</option>
                        <option value="rejected" {{ $article->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                        <option value="pending_journal_owner" {{ $article->status == 'pending_journal_owner' ? 'selected' : '' }}>Dergi Sahibi Onayı Bekliyor</option>
                        <option value="pending_admin" {{ $article->status == 'pending_admin' ? 'selected' : '' }}>Admin Onayı Bekliyor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="issue_id">Sayıya (Issue) Ata</label>
                    @if($article->journal_id)
                        @if($issues->count() > 0)
                            <select id="issue_id" name="issue_id" class="form-control">
                                <option value="">-- Erken Görünüm (Sayıya Atanmamış) --</option>
                                @foreach($issues as $issue)
                                    <option value="{{ $issue->id }}" {{ $article->issue_id == $issue->id ? 'selected' : '' }}>
                                        {{ $issue->year }} - Cilt {{ $issue->volume ?? '?' }}, Sayı {{ $issue->number }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <div style="padding: 1.5rem; background: var(--bg-main); border-radius: 1rem; border: 1px solid var(--border);">
                                <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">
                                    Bu dergiye ait henüz bir sayı bulunmuyor. <br>
                                    <a href="{{ route('issues.create') }}" style="color: var(--accent); font-weight: 700; text-decoration: none;">Yeni Sayı Oluştur →</a>
                                </p>
                            </div>
                        @endif
                    @else
                        <div style="padding: 1.5rem; background: var(--bg-main); border-radius: 1rem; border: 1px solid var(--border);">
                            <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">Bağımsız makaleler herhangi bir derginin sayısına atanamaz.</p>
                        </div>
                    @endif
                </div>

                <div style="margin-top: 3rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">Değişiklikleri Kaydet</button>
                </div>
            </form>
        </div>
    </main>

    @include('layouts.footer')
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
