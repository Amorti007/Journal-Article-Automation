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
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-sm transition font-medium">Onayla</button>
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
                                    <p class="text-sm" style="color: var(--text-secondary);">Yazar: {{ $article->user->name ?? 'Bilinmiyor' }} | Dergi: {{ $article->journal ? $article->journal->name : 'Bağımsız' }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.articles.approve', $article->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-sm transition font-medium">Onayla</button>
                                    </form>
                                    <form action="{{ route('admin.articles.reject', $article->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition font-medium">Reddet</button>
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
                        <h4 class="font-semibold mb-2 p-2 rounded" style="color: var(--text-primary); background: var(--bg-main);">Tüm Makaleler</h4>
                        <ul class="divide-y border rounded max-h-60 overflow-y-auto" style="border-color: var(--border); background: var(--bg-main);">
                            @foreach($allArticles as $article)
                                <li class="p-2 flex justify-between items-center text-sm transition" style="border-color: var(--border); color: var(--text-secondary);">
                                    <span class="truncate pr-2">{{ $article->title }} {!! $article->delete_requested ? '<span class="text-xs text-red-500 bg-red-500/10 px-1 rounded ml-1">Silinme İstendi</span>' : '' !!}</span>
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
