document.addEventListener('DOMContentLoaded', function() {
    if (
        (window.location.pathname !== '/portfolio_melchior/public/' &&
         window.location.pathname !== '/portfolio_melchior/public/index.php') ||
        window.location.search.includes('=oeuvre') ||
        window.location.search.includes('route=filtered_artworks')
    ) {
        const header = document.querySelector('header');
        if (header) {
            header.classList.remove('background-header');
        }

        document.querySelectorAll('.text-white').forEach(element => {
            element.classList.remove('text-white');
            element.classList.add('text-black');
        });

        const navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.classList.remove('navbar-dark');
        }

        const mainName = document.getElementById('main-name');
        if (mainName) {
            mainName.style.display = 'none';
        }
    }

    const envelopeIcon = document.querySelector('.fa-envelope');
    if (envelopeIcon) {
        envelopeIcon.addEventListener('click', function() {
            const nameInput = document.getElementById('name');
            if (nameInput) {
                nameInput.focus();
            }
        });
    }
});
