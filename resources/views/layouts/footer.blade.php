<footer>
    <div class="container footer-content">
        <div class="footer-brand">
            <h2>MagReview</h2>
            <p>Akademik bilginin özgürce paylaşıldığı ve değerlendirildiği modern platform.</p>
        </div>
        <div class="footer-links">
            <h4>Platform</h4>
            <ul>
                <li><a href="{{ route('journals.index') }}">Dergiler</a></li>
                <li><a href="{{ route('articles.index') }}">Makaleler</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Kurumsal</h4>
            <ul>
                <li><a href="#">Hakkımızda</a></li>
                <li><a href="#">İletişim</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Destek</h4>
            <ul>
                <li><a href="#">Yardım Merkezi</a></li>
                <li><a href="#">SSS</a></li>
                <li><a href="#">Yazım Kuralları</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom" style="text-align: center; width: 100%;">
        <p>&copy; {{ date('Y') }} MagReview. Tüm hakları saklıdır. Akademik dünyayı birlikte inşa ediyoruz.</p>
    </div>
</footer>
