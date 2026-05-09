<header class="navbar">
    <div class="container navbar-content">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('resim/logo.png') }}" alt="MagReview Logo" class="logo-img">
        </a>
        <nav class="nav-links">
            <a href="{{ route('journals.index') }}" class="nav-link {{ request()->routeIs('journals.*') ? 'active-link' : '' }}" @if(request()->routeIs('journals.*')) style="color: var(--accent); font-weight: 700;" @endif>Dergiler</a>
            <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active-link' : '' }}" @if(request()->routeIs('articles.*')) style="color: var(--accent); font-weight: 700;" @endif>Makaleler</a>
        </nav>
        <div style="flex: 1; display: flex; justify-content: center; padding: 0 1rem; margin: 0 1rem;">
            <form action="{{ route('articles.index') }}" method="GET" style="display: flex; align-items: center; background: var(--bg-main); border: 1px solid var(--border); border-radius: 2rem; padding: 0.25rem 0.5rem; width: 100%; max-width: 400px; transition: border-color 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.5rem; color: var(--text-secondary)"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                <input type="text" name="search" placeholder="Makale veya dergi ara..." style="border: none; background: transparent; outline: none; padding: 0.4rem 0.5rem; width: 100%; font-size: 0.875rem; color: var(--text-primary);">
            </form>
        </div>
        <div class="nav-actions">
            <button id="themeToggle" class="theme-btn" title="Temayı Değiştir">
                <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M22 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                <svg class="moon-icon" style="display:none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
            </button>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">Giriş Yap</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">Kayıt Ol</a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">Panele Git</a>
                <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">Çıkış Yap</button>
                </form>
            @endauth
        </div>
    </div>
</header>
