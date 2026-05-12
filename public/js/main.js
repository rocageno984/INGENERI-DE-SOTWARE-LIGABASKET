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

    // Toast Notification System
    const toastContainer = document.querySelector('.toast-container');

    window.showToast = (message, type = 'success') => {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        let icon = 'fa-check-circle';
        if (type === 'danger') icon = 'fa-exclamation-circle';
        if (type === 'warning') icon = 'fa-exclamation-triangle';

        toast.innerHTML = `
            <div class="toast-icon"><i class="fas ${icon}"></i></div>
            <div class="toast-content">${message}</div>
            <div class="toast-close"><i class="fas fa-times"></i></div>
        `;

        toastContainer.appendChild(toast);

        // Show animation
        setTimeout(() => toast.classList.add('show'), 10);

        // Auto remove
        const timer = setTimeout(() => {
            removeToast(toast);
        }, 5000);

        // Close on click
        toast.querySelector('.toast-close').addEventListener('click', () => {
            clearTimeout(timer);
            removeToast(toast);
        });
    };

    function removeToast(toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 4000);
    }
});
