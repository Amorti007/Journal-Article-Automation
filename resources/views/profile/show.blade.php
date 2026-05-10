<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Profile Header -->
            <div style="background: var(--bg-card); border: 1px solid var(--border);" class="overflow-hidden shadow-lg sm:rounded-3xl p-8 relative">
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-rose-900 to-rose-700 opacity-20"></div>
                
                <div class="relative flex flex-col md:flex-row items-center md:items-end gap-6 mt-8">
                    <div class="w-32 h-32 rounded-2xl overflow-hidden border-4 border-white shadow-xl bg-white flex-shrink-0">
                        @if($user->profile_image)
                            <img src="{{ asset($user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-rose-50 flex items-center justify-center text-rose-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-extrabold" style="color: var(--text-primary);">{{ $user->name }}</h1>
                        <p class="text-lg font-medium" style="color: var(--accent);">{{ $user->title ?? 'Akademisyen / Araştırmacı' }}</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3">
                            @if($user->linkedin_url)
                                <a href="{{ $user->linkedin_url }}" target="_blank" class="flex items-center gap-1.5 text-sm font-semibold hover:underline" style="color: var(--text-secondary);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                    LinkedIn
                                </a>
                            @endif
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank" class="flex items-center gap-1.5 text-sm font-semibold hover:underline" style="color: var(--text-secondary);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    Web Sitesi
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    @if(auth()->id() === $user->id)
                        <div class="pb-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline text-sm py-2 px-4">Profili Düzenle</a>
                        </div>
                    @endif
                </div>

                <div class="mt-8 border-t pt-6" style="border-color: var(--border);">
                    <h2 class="text-sm font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Hakkında</h2>
                    <p class="text-lg leading-relaxed" style="color: var(--text-primary);">
                        {{ $user->bio ?? 'Henüz bir biyografi eklenmemiş.' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Stats & Info -->
                <div class="space-y-6">
                    <div style="background: var(--bg-card); border: 1px solid var(--border);" class="rounded-2xl p-6 shadow-sm">
                        <h3 class="font-bold text-lg mb-4" style="color: var(--text-primary);">İstatistikler</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span style="color: var(--text-secondary);">Yayınlanan Dergiler</span>
                                <span class="font-bold" style="color: var(--accent);">{{ $user->journals->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span style="color: var(--text-secondary);">Toplam Makale</span>
                                <span class="font-bold" style="color: var(--accent);">{{ $user->articles->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span style="color: var(--text-secondary);">Yorumlar</span>
                                <span class="font-bold" style="color: var(--accent);">{{ $user->comments->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Contributions -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Journals -->
                    @if($user->journals->count() > 0)
                        <div>
                            <h3 class="text-2xl font-bold mb-4 flex items-center gap-2" style="color: var(--text-primary);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2v20H6.5a2.5 2.5 0 0 1 0-5H20"></path></svg>
                                Sahibi Olduğu Dergiler
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->journals as $journal)
                                    <a href="{{ route('journals.show', $journal->id) }}" style="background: var(--bg-card); border: 1px solid var(--border);" class="group p-5 rounded-2xl shadow-sm hover:shadow-md transition border-l-4 border-l-rose-800">
                                        <h4 class="font-bold text-lg group-hover:text-rose-800 transition" style="color: var(--text-primary);">{{ $journal->name }}</h4>
                                        <p class="text-sm mt-1" style="color: var(--text-secondary);">{{ $journal->articles_count }} Makale</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Articles -->
                    @if($user->articles->count() > 0)
                        <div>
                            <h3 class="text-2xl font-bold mb-4 flex items-center gap-2" style="color: var(--text-primary);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>
                                Yayınladığı Makaleler
                            </h3>
                            <div class="space-y-4">
                                @foreach($user->articles as $article)
                                    <div style="background: var(--bg-card); border: 1px solid var(--border);" class="p-6 rounded-2xl shadow-sm">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-bold text-xl" style="color: var(--text-primary);">
                                                <a href="{{ route('articles.show', $article->id) }}" class="hover:text-rose-800 transition">{{ $article->title }}</a>
                                            </h4>
                                            <span class="text-xs px-2 py-1 rounded-full uppercase font-bold tracking-tighter bg-green-50 text-green-700 border border-green-100">Onaylı</span>
                                        </div>
                                        <p class="text-sm line-clamp-2 mb-4" style="color: var(--text-secondary);">{{ $article->abstract }}</p>
                                        <div class="flex items-center justify-between mt-4 pt-4 border-t" style="border-color: var(--border);">
                                            <span class="text-xs font-medium" style="color: var(--text-secondary);">Dergi: {{ $article->journal ? $article->journal->name : 'Bağımsız' }}</span>
                                            <a href="{{ route('articles.show', $article->id) }}" class="text-rose-800 text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                                                İncele 
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user->journals->count() == 0 && $user->articles->count() == 0)
                        <div style="background: var(--bg-card); border: 1px solid var(--border);" class="p-12 rounded-3xl text-center shadow-sm">
                            <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Henüz bir katkı yok</h3>
                            <p style="color: var(--text-secondary);">Bu editör henüz yayınlanmış bir makale veya dergi sahibi değil.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
