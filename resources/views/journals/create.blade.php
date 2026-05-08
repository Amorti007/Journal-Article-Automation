<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Dergi Ekle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <div class="mb-6">
            <a href="{{ route('journals.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center transition-colors">
                &larr; Dergi Listesine Dön
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Yeni Dergi Oluştur</h1>

        <form action="{{ route('journals.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 mb-1">Dergi Adı:</label>
                <input type="text" id="name" name="name" required class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="issn" class="block font-medium text-gray-700 mb-1">ISSN:</label>
                <input type="text" id="issn" name="issn" required class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="description" class="block font-medium text-gray-700 mb-1">Açıklama (Hakkında):</label>
                <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-700 transition-colors">Dergiyi Kaydet</button>
        </form>
    </div>
</body>
</html>
