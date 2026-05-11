document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const sunIcon = themeToggle.querySelector('.sun-icon');
        const moonIcon = themeToggle.querySelector('.moon-icon');
        
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
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'block';
            } else {
                if (sunIcon) sunIcon.style.display = 'block';
                if (moonIcon) moonIcon.style.display = 'none';
            }
        }
    }

    const searchInput = document.querySelector('.search-input');
    const searchContainer = document.querySelector('.search-container');
    if (searchInput && searchContainer) {
        searchInput.addEventListener('focus', () => {
            searchContainer.style.borderColor = 'var(--accent)';
        });
    }

    // Add some random stats animation if desired
    animateStats();
});

function animateStats() {
    const stats = document.querySelectorAll('.stat-number');
    stats.forEach(stat => {
        const rawText = stat.textContent.replace(/[^0-9]/g, '');
        const target = rawText ? parseInt(rawText) : 0;
        let count = 0;
        const duration = 2000; // 2 seconds
        
        if (target === 0) {
            stat.textContent = '0';
            return;
        }

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
