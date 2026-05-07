<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Makaleler</title>
</head>
<body>
    <a href="{{ route('home') }}" style="text-decoration: none; color: blue;">&larr; Ana Sayfa (Dergiler)</a>
    <h1>Makaleler</h1>

    <!-- Başarı/Hata Mesajları -->
    @if(session('success'))
        <div style="color: green; margin-bottom: 15px; border: 1px solid green; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Arama Çubuğu -->
    <form action="{{ route('articles.index') }}" method="GET">
        <label for="search">Makale Ara:</label>
        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Başlık veya içerik...">
        <button type="submit">Ara</button>
    </form>
    <br>

    <!-- Kategori Filtresi (Açılır Menü - Dropdown) -->
    <form action="{{ route('articles.index') }}" method="GET">
        <label for="category">Kategoriye Göre Filtrele:</label>
        <select name="category_id" id="category" onchange="this.form.submit()">
            <option value="">Tüm Kategoriler</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>
    <br>

    <a href="{{ route('articles.create') }}">Yeni Makale Yükle</a>

    <hr>

    <!-- Makale Listesi -->
    @if($articles->count() > 0)
        <ul>
            @foreach($articles as $article)
                <li>
                    <h2><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h2>
                    <p>Kategoriler: 
                        @foreach($article->categories as $category)
                            {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </p>
                    <p>Yazar ID: {{ $article->user_id }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>Henüz makale bulunmamaktadır.</p>
    @endif

</body>
</html>
