<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $article->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen pt-32 pb-20 px-6">
    @include('layouts.header', ['fixed' => true])
    <div class="max-w-5xl mx-auto">
    <a href="{{ route('articles.index') }}">Makalelere Dön</a>
    <hr>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <h1 style="margin: 0;">{{ $article->title }}</h1>
            <a href="{{ route('articles.edit', $article->id) }}" style="padding: 5px 10px; background-color: #f39c12; color: white; text-decoration: none; border-radius: 4px;">Makaleyi Düzenle (Atama Yap)</a>
        </div>
        
        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Bu makaleyi kalıcı olarak silmek istediğinize emin misiniz?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="padding: 5px 10px; background-color: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer;">Makaleyi Sil</button>
        </form>
    </div>
    
    <p><strong>Yazar ID:</strong> {{ $article->user_id }}</p>
    
    <p><strong>Kategoriler:</strong>
        @foreach($article->categories as $category)
            {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
    </p>

    <p><strong>Özet:</strong><br>
        {{ $article->abstract }}
    </p>

    <!-- Dosya Görüntüleme / İndirme -->
    @if($article->pdf_path)
        <p>
            <a href="{{ asset($article->pdf_path) }}" target="_blank" style="margin-right: 10px;">
                <button type="button">Görüntüle</button>
            </a>
            <a href="{{ route('articles.download', $article->id) }}">
                <button type="button">İndir</button>
            </a>
        </p>
    @else
        <p>Bu makale için yüklenmiş bir dosya bulunmuyor.</p>
    @endif

    <hr>

    <!-- Yorumlar Bölümü -->
    <h3>Yorumlar ({{ $article->comments->count() }})</h3>
    <ul>
        @foreach($article->comments as $comment)
            <li>
                <strong>{{ $comment->user->name ?? 'Bilinmeyen Kullanıcı' }}:</strong> {{ $comment->content }}
                
                <!-- Yorum Silme (Opsiyonel) -->
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Sil</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Yorum Ekleme Formu -->
    <h4>Yorum Ekle</h4>
    <form action="{{ route('comments.store', $article->id) }}" method="POST">
        @csrf
        <textarea name="content" rows="3" required placeholder="Yorumunuzu buraya yazın..."></textarea><br>
        <button type="submit">Gönder</button>
    </form>
    </div>
    @include('layouts.footer', ['fixed' => true])
</body>
</html>
