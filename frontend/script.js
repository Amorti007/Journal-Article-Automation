document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const sunIcon = themeToggle.querySelector('.sun-icon');
    const moonIcon = themeToggle.querySelector('.moon-icon');
    const mainActionBtn = document.getElementById('mainActionBtn');
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateIcons(savedTheme);

    // Theme Toggle Click Handler
    themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcons(newTheme);
    });

    function updateIcons(theme) {
        if (theme === 'dark') {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
        } else {
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
        }
    }

    // User State Simulation with localStorage
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    
    // Update main action button on homepage if it exists
    if (mainActionBtn) {
        if (isLoggedIn) {
            mainActionBtn.textContent = 'Makale Göz At';
            mainActionBtn.href = 'makaleler.html';
        } else {
            mainActionBtn.textContent = 'Hemen Kayıt Ol';
            mainActionBtn.href = 'kayit.html';
        }
    }

    // Dynamic Navbar Login/Logout buttons
    const navActions = document.querySelector('.nav-actions');
    if (navActions) {
        // Clear existing hardcoded auth buttons
        const authBtns = navActions.querySelectorAll('a.btn');
        authBtns.forEach(btn => btn.remove());

        if (isLoggedIn) {
            const profileBtn = document.createElement('a');
            profileBtn.href = '#';
            profileBtn.className = 'btn btn-outline';
            profileBtn.style.padding = '0.5rem 1.25rem';
            profileBtn.style.fontSize = '0.875rem';
            profileBtn.textContent = 'Profilim';

            const logoutBtn = document.createElement('a');
            logoutBtn.href = '#';
            logoutBtn.className = 'btn btn-primary';
            logoutBtn.style.padding = '0.5rem 1.25rem';
            logoutBtn.style.fontSize = '0.875rem';
            logoutBtn.textContent = 'Çıkış Yap';
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('isLoggedIn');
                window.location.reload();
            });

            navActions.appendChild(profileBtn);
            navActions.appendChild(logoutBtn);
        } else {
            const loginBtn = document.createElement('a');
            loginBtn.href = 'giris.html';
            loginBtn.className = 'btn btn-outline';
            loginBtn.style.padding = '0.5rem 1.25rem';
            loginBtn.style.fontSize = '0.875rem';
            loginBtn.textContent = 'Giriş Yap';

            const registerBtn = document.createElement('a');
            registerBtn.href = 'kayit.html';
            registerBtn.className = 'btn btn-primary';
            registerBtn.style.padding = '0.5rem 1.25rem';
            registerBtn.style.fontSize = '0.875rem';
            registerBtn.textContent = 'Kayıt Ol';

            navActions.appendChild(loginBtn);
            navActions.appendChild(registerBtn);
        }
    }

    // Smooth Scroll for search section (Optional polish)
    const searchInput = document.querySelector('.search-input');
    searchInput.addEventListener('focus', () => {
        document.querySelector('.search-container').style.borderColor = 'var(--accent)';
    });

    // Add some random stats animation if desired
    animateStats();
});

function animateStats() {
    const stats = document.querySelectorAll('.stat-number');
    stats.forEach(stat => {
        const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
        let count = 0;
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        
        const updateCount = () => {
            if (count < target) {
                count += increment;
                stat.textContent = Math.ceil(count).toLocaleString() + '+';
                requestAnimationFrame(updateCount);
            } else {
                stat.textContent = target.toLocaleString() + '+';
            }
        };
        updateCount();
    });
}
