import Swal from 'sweetalert2';

// Handle delete confirmations using event delegation
document.addEventListener('submit', (e) => {
    const form = e.target;
    
    // Check if the form has the data-confirm-delete attribute
    if (form.hasAttribute('data-confirm-delete')) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the attribute to prevent infinite loop
                form.removeAttribute('data-confirm-delete');
                form.submit();
            }
        });
    }
});

// Show success messages from session
document.addEventListener('DOMContentLoaded', () => {
    const successMessage = document.querySelector('[data-success-message]');
    if (successMessage) {
        const message = successMessage.dataset.successMessage;
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            confirmButtonColor: '#4f46e5',
            timer: 3000,
            timerProgressBar: true
        });
    }

    // Show error messages from session
    const errorMessage = document.querySelector('[data-error-message]');
    if (errorMessage) {
        const message = errorMessage.dataset.errorMessage;
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonColor: '#ef4444'
        });
    }
});

