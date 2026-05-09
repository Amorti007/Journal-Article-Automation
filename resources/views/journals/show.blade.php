<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $journal->name }} - Dergi Detayları</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen pt-32 pb-20">
    @include('layouts.header', ['fixed' => true])
    <div class="max-w-5xl mx-auto">
        <!-- Geri Dönüş Linki -->
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('journals.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Dergi Listesine Dön
            </a>
            
            <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" onsubmit="return confirm('Bu dergiyi silmek istediğinize emin misiniz? Dergiye ait tüm sayılar ve makaleler de silinecektir!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white font-semibold py-1.5 px-4 rounded-md hover:bg-red-700 transition-colors flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Dergiyi Sil
                </button>
            </form>
        </div>

        <!-- Dergi Başlık Kartı -->
        <div class="bg-white p-8 rounded-xl shadow-md mb-8 border-l-4 border-blue-600">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $journal->name }}</h1>
            <p class="text-gray-500 font-medium mb-4">ISSN: {{ $journal->issn }}</p>
            @if($journal->description)
                <p class="text-gray-700 leading-relaxed">{{ $journal->description }}</p>
            @endif
        </div>

        <!-- İçerikler Bölümü -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Yayımlanan Sayılar ve Makaleler</h2>

        <div class="space-y-4">
            <!-- Her Sayı (Issue) İçin Accordion Yapısı -->
            @forelse($journal->issues as $issue)
                <!-- AlpineJS tabanlı basit accordion -->
                <div class="bg-white rounded-lg shadow-sm border overflow-hidden" x-data="{ expanded: false }">
                    <button @click="expanded = !expanded" class="w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 flex justify-between items-center transition-colors focus:outline-none">
                        <div class="font-bold text-lg text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-500 transition-transform duration-200" :class="{'rotate-90': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ $issue->volume ? $issue->volume . ' - ' : '' }} {{ $issue->number }} ({{ $issue->year }})
                        </div>
                        <div>
                            <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-medium">{{ $issue->articles->count() }} Makale</span>
                        </div>
                    </button>
                    
                    <div x-show="expanded" x-collapse x-cloak>
                        <ul class="divide-y divide-gray-100 bg-white">
                            @forelse($issue->articles as $article)
                                <li class="px-8 py-5 hover:bg-blue-50/50 transition-colors group">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1 pr-4">
                                            <a href="{{ route('articles.show', $article->id) }}" class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 block mb-1 transition-colors">
                                                {{ $article->title }}
                                            </a>
                                            <p class="text-xs text-gray-500 mb-2">Yazar ID: {{ $article->user_id }} &bull; Yüklenme: {{ $article->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex-shrink-0 pt-1">
                                            @if($article->status)
                                                <span class="text-xs uppercase tracking-wider font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-md">
                                                    {{ $article->status }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($article->abstract)
                                        <p class="text-gray-600 mt-2 text-sm leading-relaxed">{{ $article->abstract }}</p>
                                    @endif
                                    <div class="mt-3 flex gap-4">
                                        <a href="{{ route('articles.show', $article->id) }}" class="text-sm text-blue-600 font-medium hover:text-blue-800 inline-flex items-center">
                                            Makale Detayı <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('articles.download', $article->id) }}" class="text-sm text-gray-600 font-medium hover:text-gray-800 inline-flex items-center">
                                            PDF İndir <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    </div>
                                </li>
                            @empty
                                <li class="px-8 py-5 text-gray-500 italic">Bu sayıda henüz makale bulunmuyor.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-lg border text-gray-600 italic shadow-sm">
                    Bu dergiye ait henüz bir sayı (issue) oluşturulmamış.
                </div>
            @endforelse

            <!-- Erken Görünüm (Sayıya Atanmamış) Makaleler -->
            @if($unassignedArticles->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-yellow-200 overflow-hidden mt-8" x-data="{ expanded: true }">
                    <button @click="expanded = !expanded" class="w-full text-left px-6 py-4 bg-gradient-to-r from-yellow-50 to-white hover:from-yellow-100 flex justify-between items-center transition-colors focus:outline-none">
                        <div class="font-bold text-lg text-yellow-800 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-yellow-600 transition-transform duration-200" :class="{'rotate-90': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Sayı Bekleyen Makaleler (Erken Görünüm)
                        </div>
                        <div>
                            <span class="text-sm bg-yellow-100 border border-yellow-200 text-yellow-800 py-1 px-3 rounded-full font-medium">{{ $unassignedArticles->count() }} Makale</span>
                        </div>
                    </button>
                    
                    <div x-show="expanded" x-collapse>
                        <ul class="divide-y divide-yellow-100/50 bg-white">
                            @foreach($unassignedArticles as $article)
                                <li class="px-8 py-5 hover:bg-yellow-50/50 transition-colors group">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1 pr-4">
                                            <a href="{{ route('articles.show', $article->id) }}" class="text-lg font-semibold text-gray-800 group-hover:text-yellow-700 block mb-1 transition-colors">
                                                {{ $article->title }}
                                            </a>
                                            <p class="text-xs text-gray-500 mb-2">Yazar ID: {{ $article->user_id }} &bull; Yüklenme: {{ $article->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex-shrink-0 pt-1">
                                            @if($article->status)
                                                <span class="text-xs uppercase tracking-wider font-semibold text-yellow-800 bg-yellow-100 px-2.5 py-1 rounded-md">
                                                    {{ $article->status }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($article->abstract)
                                        <p class="text-gray-600 mt-2 text-sm leading-relaxed">{{ $article->abstract }}</p>
                                    @endif
                                    <div class="mt-3 flex gap-4">
                                        <a href="{{ route('articles.show', $article->id) }}" class="text-sm text-yellow-600 font-medium hover:text-yellow-800 inline-flex items-center">
                                            Makale Detayı <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('articles.download', $article->id) }}" class="text-sm text-gray-600 font-medium hover:text-gray-800 inline-flex items-center">
                                            PDF İndir <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('layouts.footer', ['fixed' => true])
</body>
</html>
