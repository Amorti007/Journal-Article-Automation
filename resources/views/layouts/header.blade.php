<header class="{{ ($fixed ?? false) ? 'fixed top-0 left-0 right-0 z-50' : '' }}" style="background-color:#6f1021;border-bottom:1px solid #8c3141;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <a href="/" class="text-3xl font-extrabold tracking-wider text-rose-50" style="color:#fff1f2;">
                DERGİ MAKALE SİSTEMİ
            </a>

            <div class="flex flex-wrap items-center gap-2 p-2 rounded-xl border" style="background-color:rgba(255,241,242,.15);border-color:rgba(255,241,242,.30);">
                <a href="{{ route('articles.index') }}" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffdfe5;">Makaleler</a>

                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <a href="{{ route('journals.create') }}" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffdfe5;">+ Yeni Dergi</a>
                        <a href="{{ route('issues.create') }}" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffe7eb;">+ Yeni Sayı</a>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffe7eb;">Giriş Yap</a>
                    <a href="{{ route('register') }}" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffe7eb;">Kayıt Ol</a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffe7eb;">Panele Git</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="font-semibold px-3 py-2 rounded-lg" style="color:#5f0f1f;background-color:#ffe7eb;">Çıkış Yap</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>
