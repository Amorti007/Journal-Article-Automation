<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="background: var(--bg-card); border: 1px solid var(--border); color: var(--text-primary);" class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-6" style="font-family: 'Outfit', sans-serif;">Hoş Geldin, {{ Auth::user()->name }}! </h3>

    <!-- İstatistik Kartları Grid'i -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-item" style="background: var(--bg-main); border: 1px solid var(--border); padding: 1.5rem; border-radius: 1rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <h4 class="stat-label">Okunan Makaleler</h4>
            <p class="stat-number mt-2">12</p>
        </div>
        <div class="stat-item" style="background: var(--bg-main); border: 1px solid var(--border); padding: 1.5rem; border-radius: 1rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <h4 class="stat-label">Favori Dergiler</h4>
            <p class="stat-number mt-2">5</p>
        </div>
        <div class="stat-item" style="background: var(--bg-main); border: 1px solid var(--border); padding: 1.5rem; border-radius: 1rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <h4 class="stat-label">Yorumlarım</h4>
            <p class="stat-number mt-2">8</p>
        </div>
    </div>

    <!-- Son Aktiviteler Alanı -->
    <div style="background: var(--bg-main); border: 1px solid var(--border); padding: 1.5rem; border-radius: 1rem; box-shadow: var(--shadow-sm);">
        <h4 class="font-bold border-b pb-3 mb-4" style="color: var(--text-primary); border-color: var(--border);">Son Aktiviteler</h4>
        <ul class="text-sm space-y-3" style="color: var(--text-secondary);">
            <li class="flex items-center gap-3">
                <span style="background: var(--accent-soft); color: var(--accent); padding: 0.5rem; border-radius: 9999px; display: inline-flex;">📖</span>
                "Yapay Zeka ve Gelecek" makalesini okudun.
            </li>
            <li class="flex items-center gap-3">
                <span style="background: var(--accent-soft); color: var(--accent); padding: 0.5rem; border-radius: 9999px; display: inline-flex;">🔖</span>
                "Bilim Dergisi - Mayıs Sayısı" favorilere eklendi.
            </li>
        </ul>
    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
