<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dergi Kataloğu</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Test için hızlı Tailwind -->
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-3xl font-bold mb-6">Dergiler</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($journals as $journal)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">{{ $journal->name }}</h2>
                <p class="text-gray-600">ISSN: {{ $journal->issn }}</p>
                <p class="mt-2 text-sm text-blue-500">Makale Sayısı: {{ $journal->articles_count }}</p>
            </div>
        @empty
            <p>Henüz dergi bulunamadı. Lütfen 'sail artisan migrate:fresh --seed' komutunu çalıştırdığından emin ol.</p>
        @endforelse
    </div>
</body>
</html>