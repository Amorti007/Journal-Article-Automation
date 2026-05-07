<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $article->title }}</title>
</head>
<body>
    <a href="{{ route('articles.index') }}">Makalelere Dön</a>
    <hr>

    <h1>{{ $article->title }}</h1>
    
    <p><strong>Yazar ID:</strong> {{ $article->user_id }}</p>
    
    <p><strong>Kategoriler:</strong>
        @foreach($article->categories as $category)
            {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
    </p>

    <p><strong>İçerik:</strong><br>
        {{ $article->content }}
    </p>

    <!-- Dosya Görüntüleme / İndirme -->
    @if($article->file_path)
        <p>
            <a href="{{ asset($article->file_path) }}" target="_blank" style="margin-right: 10px;">
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
                <strong>Kullanıcı {{ $comment->user_id }}:</strong> {{ $comment->content }}
                
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

</body>
</html>
