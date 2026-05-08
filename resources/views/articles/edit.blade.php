<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Makale Düzenle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <div class="mb-6">
            <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center transition-colors">
                &larr; Makaleye Dön
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-2">Makale Düzenle: {{ $article->title }}</h1>
        <p class="text-sm text-gray-500 mb-6">Mevcut Durum: <strong>{{ $article->status }}</strong></p>

        <form action="{{ route('articles.update', $article->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="status" class="block font-medium text-gray-700 mb-1">Durumu Değiştir:</label>
                <select id="status" name="status" required class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
                    <option value="editor_review" {{ $article->status == 'editor_review' ? 'selected' : '' }}>Editör İncelemesinde</option>
                    <option value="peer_review" {{ $article->status == 'peer_review' ? 'selected' : '' }}>Hakem İncelemesinde</option>
                    <option value="accepted" {{ $article->status == 'accepted' ? 'selected' : '' }}>Kabul Edildi</option>
                    <option value="rejected" {{ $article->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="issue_id" class="block font-medium text-gray-700 mb-1">Sayıya (Issue) Ata:</label>
                @if($article->journal_id)
                    @if($issues->count() > 0)
                        <select id="issue_id" name="issue_id" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
                            <option value="">-- Erken Görünüm (Sayıya Atanmamış) --</option>
                            @foreach($issues as $issue)
                                <option value="{{ $issue->id }}" {{ $article->issue_id == $issue->id ? 'selected' : '' }}>
                                    Cilt {{ $issue->volume }}, Sayı {{ $issue->number }} ({{ $issue->year }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-red-500 mt-1">Bu makalenin bulunduğu dergiye henüz bir sayı eklenmemiş. Önce <a href="{{ route('issues.create') }}" class="underline font-semibold">yeni bir sayı</a> oluşturmalısınız.</p>
                    @endif
                @else
                    <p class="text-sm text-gray-500 mt-1">Bağımsız makaleler herhangi bir derginin sayısına atanamaz.</p>
                @endif
            </div>

            <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-700 transition-colors">Değişiklikleri Kaydet</button>
        </form>
    </div>
</body>
</html>
