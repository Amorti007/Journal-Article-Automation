<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-6">Hoş Geldin, {{ Auth::user()->name }}! </h3>

    <!-- İstatistik Kartları Grid'i -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 shadow-sm">
            <h4 class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Okunan Makaleler</h4>
            <p class="text-3xl font-black text-blue-900 mt-2">12</p>
        </div>
        <div class="bg-green-50 p-5 rounded-xl border border-green-100 shadow-sm">
            <h4 class="text-green-600 font-semibold text-sm uppercase tracking-wider">Favori Dergiler</h4>
            <p class="text-3xl font-black text-green-900 mt-2">5</p>
        </div>
        <div class="bg-purple-50 p-5 rounded-xl border border-purple-100 shadow-sm">
            <h4 class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Yorumlarım</h4>
            <p class="text-3xl font-black text-purple-900 mt-2">8</p>
        </div>
    </div>

    <!-- Son Aktiviteler Alanı -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <h4 class="font-bold text-gray-800 border-b pb-3 mb-4">Son Aktiviteler</h4>
        <ul class="text-sm space-y-3 text-gray-600">
            <li class="flex items-center gap-2">
                <span class="bg-blue-100 text-blue-600 p-1.5 rounded-full">📖</span>
                "Yapay Zeka ve Gelecek" makalesini okudun.
            </li>
            <li class="flex items-center gap-2">
                <span class="bg-green-100 text-green-600 p-1.5 rounded-full">🔖</span>
                "Bilim Dergisi - Mayıs Sayısı" favorilere eklendi.
            </li>
        </ul>
    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
