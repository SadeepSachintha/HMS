function confirmDelete(formElement) {
    event.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            formElement.submit();
        }
    });
}

// Handle delete buttons with data attributes
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const itemName = this.dataset.itemName || 'this item';
            const customMessage = this.dataset.confirmMessage || `You won't be able to revert this!`;

            Swal.fire({
                title: `Delete ${itemName}?`,
                text: customMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = this.closest('form');
                    if (form) {
                        form.submit();
                    } else {
                        window.location.href = this.href;
                    }
                }
            });
        });
    });
});
