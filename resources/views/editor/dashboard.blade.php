<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary);">
            {{ __('Editör Paneli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Hızlı İşlemler -->
            <div style="background: var(--bg-card); border: 1px solid var(--border); border-left: 4px solid var(--accent);" class="overflow-hidden shadow-sm rounded-xl p-6">
                <div class="flex flex-row gap-4 sm:gap-6 w-full">
                    <a href="{{ route('journals.create') }}" 
                       style="background-color: var(--accent); color: white; border: none; flex: 1;" 
                       class="justify-center px-4 sm:px-6 py-4 rounded-xl hover:opacity-90 transition shadow-md font-bold flex items-center gap-2 sm:gap-3 text-center text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path></svg>
                        <span>Yeni Dergi</span>
                    </a>
                    <a href="{{ route('articles.create') }}" 
                       style="background-color: var(--accent); color: white; border: none; flex: 1;" 
                       class="justify-center px-4 sm:px-6 py-4 rounded-xl hover:opacity-90 transition shadow-md font-bold flex items-center gap-2 sm:gap-3 text-center text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                        <span>Yeni Makale</span>
                    </a>
                </div>
            </div>

            <!-- Benim Dergilerime Gelen İstekler -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid #3b82f6;" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2" style="color: var(--text-primary); border-color: var(--border);">Dergilerime Gelen Makale İstekleri</h3>
                @if($incomingRequests->isEmpty())
                    <p style="color: var(--text-secondary); background: var(--bg-main);" class="text-sm p-3 rounded">Gelen istek yok.</p>
                @else
                    <ul class="divide-y border rounded-lg" style="border-color: var(--border); border-color: var(--border);">
                        @foreach($incomingRequests as $article)
                            <li class="p-4 flex flex-col md:flex-row items-center justify-between transition hover:bg-black/5">
                                <div class="mb-3 md:mb-0 w-full md:w-auto">
                                    <h4 class="font-semibold" style="color: var(--text-primary);">{{ $article->title }}</h4>
                                    <p class="text-sm" style="color: var(--text-secondary);">Gönderen: {{ $article->user->name ?? 'Bilinmiyor' }} | Dergi: {{ $article->journal->name }}</p>
                                </div>
                                <div class="w-full md:w-auto flex flex-col sm:flex-row gap-2">
                                    <form action="{{ route('editor.articles.approve', $article->id) }}" method="POST" class="flex gap-2 items-center w-full sm:w-auto">
                                        @csrf @method('PATCH')
                                        <select name="issue_id" class="rounded-md text-sm h-9 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto" style="background: var(--bg-main); color: var(--text-primary); border-color: var(--border);" required>
                                            <option value="">Sayı Seçin</option>
                                            @foreach($article->journal->issues as $issue)
                                                <option value="{{ $issue->id }}">Cilt {{ $issue->volume }}, Sayı {{ $issue->number }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-sm transition h-9 whitespace-nowrap font-medium">Kabul Et ve Sayıya Ata</button>
                                    </form>
                                    <form action="{{ route('editor.articles.reject', $article->id) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-sm transition h-9 w-full sm:w-auto font-medium">Reddet</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Benim Makalelerim -->
            <div style="background: var(--bg-card); border-color: var(--border);" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2" style="color: var(--text-primary); border-color: var(--border);">Yüklediğim Makaleler</h3>
                @if($myArticles->isEmpty())
                    <p style="color: var(--text-secondary);" class="text-sm">Henüz makale yüklemediniz.</p>
                @else
                    <ul class="divide-y border rounded-lg" style="border-color: var(--border);">
                        @foreach($myArticles as $article)
                            <li class="p-4 flex items-center justify-between transition hover:bg-black/5">
                                <div>
                                    <h4 class="font-semibold" style="color: var(--text-primary);">{{ $article->title }}</h4>
                                    <p class="text-xs" style="color: var(--text-secondary);">Durum: <span style="background: var(--bg-main); color: var(--text-primary);" class="px-2 py-0.5 rounded-full font-medium">{{ $article->status }}</span> | {{ $article->journal ? $article->journal->name : 'Bağımsız' }}</p>
                                </div>
                                <div>
                                    @if(!$article->delete_requested)
                                        <form action="{{ route('editor.articles.requestDelete', $article->id) }}" method="POST" onsubmit="return confirm('Silme isteği göndermek istediğinize emin misiniz?');">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 px-3 py-1 border border-red-500 rounded text-sm font-medium transition">Silme İsteği Gönder</button>
                                        </form>
                                    @else
                                        <span class="text-orange-600 bg-orange-100 px-3 py-1 rounded text-sm font-bold border border-orange-200">Silme İsteği Beklemede</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Dergilerimdeki Silme İstekleri -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid #ef4444;" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2" style="color: #ef4444; border-color: var(--border);">Dergilerimde Silinmek İstenen Makaleler</h3>
                @if($deleteRequests->isEmpty())
                    <p style="color: var(--text-secondary);" class="text-sm">Silme isteği yok.</p>
                @else
                    <ul class="divide-y border border-red-200 rounded-lg overflow-hidden" style="border-color: #ef444455;">
                        @foreach($deleteRequests as $article)
                            <li class="p-4 flex justify-between items-center text-sm transition hover:bg-red-500/10" style="background: #ef444405;">
                                <div>
                                    <h4 class="font-semibold text-base" style="color: var(--text-primary);">{{ $article->title }}</h4>
                                    <span class="text-xs font-medium" style="color: #ef4444;">Talep eden: {{ $article->user->name }}</span>
                                </div>
                                <form action="{{ route('editor.articles.approveDelete', $article->id) }}" method="POST" onsubmit="return confirm('Bu makalenin silinmesini onaylıyor musunuz? Son karar Admin tarafından verilecektir.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-white bg-orange-600 hover:bg-orange-700 px-4 py-2 rounded-md font-bold shadow-sm transition">Silinmesine Onay Ver</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Benim Dergilerim -->
            <div style="background: var(--bg-card); border-color: var(--border); border-left: 4px solid var(--accent);" class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 flex items-center justify-between" style="color: var(--text-primary); border-color: var(--border);">
                    Dergilerim
                    <span class="text-sm font-normal" style="color: var(--text-secondary);">{{ $myJournals->count() }} Dergi</span>
                </h3>
                @if($myJournals->isEmpty())
                     <p style="color: var(--text-secondary);" class="text-sm">Henüz derginiz yok.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($myJournals as $journal)
                            <div class="border rounded-xl p-5 flex flex-col justify-between hover:shadow-md transition" style="border-color: var(--border); background: var(--bg-main);">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg" style="color: var(--accent);">{{ $journal->name }}</h4>
                                        @if($journal->status == 'pending')
                                            <span class="text-[10px] bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-bold uppercase">Beklemede</span>
                                        @elseif($journal->status == 'approved')
                                            <span class="text-[10px] bg-green-100 text-green-800 px-2 py-0.5 rounded-full font-bold uppercase">Onaylandı</span>
                                        @else
                                            <span class="text-[10px] bg-red-100 text-red-800 px-2 py-0.5 rounded-full font-bold uppercase">Reddedildi</span>
                                        @endif
                                    </div>
                                    <p class="text-xs mb-3" style="color: var(--text-secondary);">ISSN: {{ $journal->issn }}</p>
                                    <div class="text-sm" style="color: var(--text-primary);">
                                        Toplam Sayı: <span class="font-bold">{{ $journal->issues->count() }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t flex flex-wrap gap-2 justify-between items-center" style="border-color: var(--border);">
                                    <span class="text-xs text-gray-500">{{ $journal->articles()->whereNull('issue_id')->count() }} Atanmamış Makale</span>
                                    <div class="flex gap-2">
                                        <a href="{{ route('journals.show', $journal->id) }}" class="text-xs bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-2 py-1 rounded font-medium transition">Yönet</a>
                                        @if($journal->status == 'approved')
                                            <a href="{{ route('issues.create', ['journal_id' => $journal->id]) }}" class="text-xs bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded font-medium transition">Sayı Ekle</a>
                                        @endif
                                        
                                        @if(!$journal->delete_requested)
                                            <form action="{{ route('editor.journals.requestDelete', $journal->id) }}" method="POST" onsubmit="return confirm('Dergiyi silme isteği göndermek istediğinize emin misiniz?');">
                                                @csrf
                                                <button type="submit" class="text-xs text-red-500 hover:text-white hover:bg-red-500 px-2 py-1 border border-red-500 rounded font-medium transition">Sil</button>
                                            </form>
                                        @else
                                            <span class="text-[10px] bg-orange-100 text-orange-700 px-2 py-1 rounded font-bold border border-orange-200">Silme Beklemede</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
