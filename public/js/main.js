// Basketball League Pro - Main Scripts

document.addEventListener('DOMContentLoaded', () => {
    console.log('Liga Pro inicializada...');

    // Mobile menu toggle
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const menuContainer = document.querySelector('.navbar-menu-container');
    const menuLinks = document.querySelectorAll('.navbar-links a');

    if (menuToggle && menuContainer) {
        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            menuContainer.classList.toggle('active');
            
            // Prevent scrolling when menu is open
            if (menuContainer.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        });

        // Close menu when clicking a link
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                menuContainer.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });
    }

    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(15, 23, 42, 0.95)';
                navbar.style.padding = '10px 5%';
            } else {
                navbar.style.background = 'rgba(15, 23, 42, 0.8)';
                navbar.style.padding = '0 5%';
            }
        });
    }
});
