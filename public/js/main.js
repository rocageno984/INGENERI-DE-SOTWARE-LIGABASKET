// Basketball League Pro - Main Scripts

document.addEventListener('DOMContentLoaded', () => {
    console.log('Liga Pro inicializada...');

    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(15, 23, 42, 0.95)';
            navbar.style.padding = '10px 5%';
        } else {
            navbar.style.background = 'rgba(15, 23, 42, 0.8)';
            navbar.style.padding = '0 5%';
        }
    });

    // Simple mobile menu placeholder
    // (Could add logic for a hamburger menu here)
});
