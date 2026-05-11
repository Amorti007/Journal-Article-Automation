<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary);">
            {{ __('Admin Paneli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Pending Journals -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid #6366f1;" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2" style="color: var(--text-primary); border-color: var(--border);">Onay Bekleyen Dergiler</h3>
                @if($pendingJournals->isEmpty())
                    <p style="color: var(--text-secondary);" class="text-sm">Onay bekleyen dergi yok.</p>
                @else
                    <ul class="divide-y" style="border-color: var(--border);">
                        @foreach($pendingJournals as $journal)
                            <li class="py-4 flex items-center justify-between" style="border-color: var(--border);">
                                <div>
                                    <h4 class="font-semibold" style="color: var(--text-primary);">{{ $journal->name }}</h4>
                                    <p class="text-sm" style="color: var(--text-secondary);">Editör: {{ $journal->user->name ?? 'Bilinmiyor' }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.journals.approve', $journal->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm transition font-medium">Onayla</button>
                                    </form>
                                    <form action="{{ route('admin.journals.reject', $journal->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition font-medium">Reddet</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Pending Articles -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid #3b82f6;" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2" style="color: var(--text-primary); border-color: var(--border);">Onay Bekleyen Makaleler</h3>
                @if($pendingArticles->isEmpty())
                    <p style="color: var(--text-secondary);" class="text-sm">Onay bekleyen makale yok.</p>
                @else
                    <ul class="divide-y" style="border-color: var(--border);">
                        @foreach($pendingArticles as $article)
                            <li class="py-4 flex items-center justify-between" style="border-color: var(--border);">
                                <div>
                                    <h4 class="font-semibold" style="color: var(--text-primary);">{{ $article->title }}</h4>
                                    <p class="text-sm" style="color: var(--text-secondary);">
                                        Yazar: {{ $article->user->name ?? 'Bilinmiyor' }} | 
                                        Dergi: {{ $article->journal ? $article->journal->name : 'Bağımsız' }}
                                    </p>
                                    <span class="text-xs font-bold uppercase px-2 py-0.5 rounded mt-1 inline-block {{ $article->status == 'pending_journal_owner' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $article->status == 'pending_journal_owner' ? 'Editör Onayı Bekliyor' : 'Admin Onayı Bekliyor' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($article->pdf_path)
                                        <a href="{{ asset($article->pdf_path) }}" target="_blank" style="background-color: #3b82f6 !important; color: white !important;" class="px-3 py-2 rounded text-xs font-bold transition hover:opacity-90">DOSYAYI İNCELE</a>
                                    @endif
                                    
                                    <form action="{{ route('admin.articles.reject', $article->id) }}" method="POST" class="m-0">
                                        @csrf @method('PATCH')
                                        <button type="submit" style="background-color: #dc2626 !important; color: white !important;" class="px-3 py-2 rounded text-xs font-bold transition hover:opacity-90">REDDET (SİL)</button>
                                    </form>

                                    <form action="{{ route('admin.articles.approve', $article->id) }}" method="POST" class="m-0">
                                        @csrf @method('PATCH')
                                        <button type="submit" style="background-color: #16a34a !important; color: white !important; border: 2px solid white;" class="px-4 py-2 rounded text-sm font-black transition hover:opacity-90 shadow-lg">ONAYLA VE YAYINLA</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Delete Requests (NEW) -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid #f97316;" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 flex items-center gap-2" style="color: #f97316; border-color: var(--border);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    Silme İstekleri (Editörlerden Gelen)
                </h3>
                @if($deleteRequests->isEmpty())
                    <p style="color: var(--text-secondary);" class="text-sm">Silme bekleyen makale yok.</p>
                @else
                    <ul class="divide-y" style="border-color: var(--border);">
                        @foreach($deleteRequests as $article)
                            <li class="py-4 flex items-center justify-between" style="border-color: var(--border);">
                                <div>
                                    <h4 class="font-semibold" style="color: var(--text-primary);">{{ $article->title }}</h4>
                                    <p class="text-sm" style="color: var(--text-secondary);">Talep Eden: {{ $article->user->name ?? 'Bilinmiyor' }} | Dergi: {{ $article->journal ? $article->journal->name : 'Bağımsız' }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Bu makaleyi KALICI olarak silmek istediğinize emin misiniz?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition font-bold shadow-sm">SİLİNMEYİ ONAYLA</button>
                                    </form>
                                    <form action="{{ route('admin.articles.cancelDelete', $article->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-sm transition font-medium shadow-sm">İsteği Reddet (Makaleyi Koru)</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- System Management -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid #ef4444;" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2" style="color: #ef4444; border-color: var(--border);">Sistem Yönetimi (Silme İşlemleri)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold mb-2 p-2 rounded" style="color: var(--text-primary); background: var(--bg-main);">Tüm Dergiler</h4>
                        <ul class="divide-y border rounded max-h-60 overflow-y-auto" style="border-color: var(--border); background: var(--bg-main);">
                            @foreach($allJournals as $journal)
                                <li class="p-2 flex justify-between items-center text-sm transition" style="border-color: var(--border); color: var(--text-secondary);">
                                    <span>{{ $journal->name }}</span>
                                    <form action="{{ route('admin.journals.destroy', $journal->id) }}" method="POST" onsubmit="return confirm('Bu dergiyi kalıcı olarak silmek istediğinize emin misiniz?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold px-2 py-1 bg-red-500/10 rounded transition">Sil</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2 p-2 rounded" style="color: var(--text-primary); background: var(--bg-main);">Sistemdeki Onaylı Makaleler</h4>
                        <ul class="divide-y border rounded max-h-60 overflow-y-auto" style="border-color: var(--border); background: var(--bg-main);">
                            @foreach($allArticles as $article)
                                <li class="p-2 flex justify-between items-center text-sm transition" style="border-color: var(--border); color: var(--text-secondary);">
                                    <span class="truncate pr-2">{{ $article->title }}</span>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Bu makaleyi kalıcı olarak silmek istediğinize emin misiniz?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold px-2 py-1 bg-red-500/10 rounded transition">Sil</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
