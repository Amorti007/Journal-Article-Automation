<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dergi Kataloğu</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Test için hızlı Tailwind -->
</head>
<body class="bg-gray-100 min-h-screen flex flex-col pt-32 pb-20">
    @include('layouts.header', ['fixed' => true])

    <div class="flex-1 p-10">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Dergiler</h1>
    
        
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
    </div>
    @include('layouts.footer', ['fixed' => true])
</body>
</html>