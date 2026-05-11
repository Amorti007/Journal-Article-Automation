<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol | MagReview</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        .auth-section {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 1rem;
            background: linear-gradient(135deg, var(--bg-main) 0%, var(--accent-soft) 100%);
        }

        .auth-card {
            background-color: var(--bg-card);
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .auth-card h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .auth-card p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
            background-color: var(--bg-main);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        .auth-links {
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .auth-links a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #b91c1c;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        <section class="auth-section">
            <div class="auth-card animate-fade-in">
                <h1>Kayıt Ol</h1>
                <p>MagReview topluluğuna katılın.</p>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">Ad Soyad</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Adınız Soyadınız" required autofocus autocomplete="name" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 error-message" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">E-posta Adresi</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="ornek@mail.com" required autocomplete="username" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 error-message" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">Şifre</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 error-message" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Şifre Tekrarı</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 error-message" />
                    </div>

                    <div class="form-group" style="display: flex; gap: 0.5rem; align-items: flex-start;">
                        <input type="checkbox" id="terms" required style="margin-top: 0.25rem;">
                        <label for="terms" style="font-size: 0.875rem; color: var(--text-secondary);">Kullanım Şartları ve Gizlilik Politikası'nı okudum ve kabul ediyorum.</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.875rem; font-size: 1.125rem;">Hesap Oluştur</button>
                </form>
                
                <div class="auth-links">
                    Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
