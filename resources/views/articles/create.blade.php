<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Makale Yükle</title>
</head>
<body>
    <h1>Yeni Makale Yükle</h1>

    <a href="{{ route('articles.index') }}">Makalelere Dön</a>
    <hr>

    <!-- Dosya yükleme (enctype="multipart/form-data") -->
    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label for="title">Başlık:</label><br>
            <input type="text" id="title" name="title" required>
        </div>
        <br>

        <div>
            <label for="categories">Kategoriler (Birden fazla seçebilirsiniz):</label><br>
            <select name="categories[]" id="categories" multiple required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <br>

        <div>
            <label for="content">İçerik / Özet:</label><br>
            <textarea id="content" name="content" rows="5" required></textarea>
        </div>
        <br>

        <div>
            <label for="file">Makale Dosyası (PDF, DOCX vb.):</label><br>
            <input type="file" id="file" name="file" accept=".pdf,.doc,.docx" required>
        </div>
        <br>

        <button type="submit">Makaleyi Yükle</button>
    </form>

</body>
</html>
