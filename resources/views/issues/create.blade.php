<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Sayı (Issue) Ekle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <div class="mb-6">
            <a href="{{ route('journals.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center transition-colors">
                &larr; Dergi Listesine Dön
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Yeni Sayı (Issue) Oluştur</h1>

        <form action="{{ route('issues.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="journal_id" class="block font-medium text-gray-700 mb-1">Ait Olduğu Dergi:</label>
                <select id="journal_id" name="journal_id" required class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
                    <option value="">-- Dergi Seçin --</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}">{{ $journal->name }} (ISSN: {{ $journal->issn }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="volume" class="block font-medium text-gray-700 mb-1">Cilt (Volume):</label>
                <input type="text" id="volume" name="volume" required placeholder="Örn: Cilt 1" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="number" class="block font-medium text-gray-700 mb-1">Sayı (Number):</label>
                <input type="text" id="number" name="number" required placeholder="Örn: Sayı 2" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="year" class="block font-medium text-gray-700 mb-1">Yıl (Year):</label>
                <input type="number" id="year" name="year" required value="{{ date('Y') }}" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-700 transition-colors">Sayıyı Kaydet</button>
        </form>
    </div>
</body>
</html>
