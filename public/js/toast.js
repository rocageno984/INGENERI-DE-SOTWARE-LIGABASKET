// Toast Notification System
const showToast = (message, type = 'success') => {
    const toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    let icon = 'fa-check-circle';
    let title = 'Éxito';
    if (type === 'danger') {
        icon = 'fa-exclamation-circle';
        title = 'Error';
    }
    if (type === 'warning') {
        icon = 'fa-exclamation-triangle';
        title = 'Atención';
    }

    toast.innerHTML = `
        <div class="toast-icon"><i class="fas ${icon}"></i></div>
        <div class="toast-content">
            <span>${title}</span>
            <p>${message}</p>
        </div>
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
    // Wait for the animation to finish before removing from DOM
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 500);
}

// Global exposure
window.showToast = showToast;
