<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dergi Kataloğu</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Test için hızlı Tailwind -->
</head>
<body class="bg-gray-100 p-10">
    <div class="flex gap-4 p-4 justify-end">
        <!-- Bizim Makaleler Linkimiz -->
        <a href="{{ route('articles.index') }}" class="font-bold text-blue-600 hover:text-blue-900">Makaleler</a>
        
    @guest
        <!-- Ziyaretçiler görecek -->
        <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-gray-900">Giriş Yap</a>
        <a href="{{ route('register') }}" class="font-bold text-gray-600 hover:text-gray-900">Kayıt Ol</a>
    @endguest

    @auth
        <!-- Giriş yapmış üyeler görecek -->
        <a href="{{ route('dashboard') }}" class="font-bold text-gray-600 hover:text-gray-900">Panele Git</a>
        
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="font-bold text-red-600 hover:text-red-900">Çıkış Yap</button>
        </form>
    @endauth
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Dergiler</h1>
        <div class="flex gap-2">
            <a href="{{ route('journals.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Yeni Dergi</a>
            <a href="{{ route('issues.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">+ Yeni Sayı</a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($journals as $journal)
            <a href="{{ route('journals.show', $journal->id) }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold">{{ $journal->name }}</h2>
                <p class="text-gray-600">ISSN: {{ $journal->issn }}</p>
                <p class="mt-2 text-sm text-blue-500">Makale Sayısı: {{ $journal->articles_count }}</p>
            </a>
        @empty
            <p>Veriler yüklenemedi.</p>
        @endforelse
    </div>
</body>
</html>