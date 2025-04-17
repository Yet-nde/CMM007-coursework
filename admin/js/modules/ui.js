// Toast notification
export function showToast(type, message) {
    const toast = `<div class="toast align-items-center text-white bg-${type} border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>`;

    $('#toastContainer').append(toast);
    $('.toast').toast({ autohide: true, delay: 3000 }).toast('show');
    $('.toast').on('hidden.bs.toast', function () {
        $(this).remove();
    });
}

// Confirmation Dialog System
export function confirmAction(message, callback) {
    const $modal = $('#confirmationModal');
    // Set message
    $('#confirmationMessage').text(message);
    $('#confirmActionBtn').off('click').on('click',() => {
        $modal.modal('hide');
        callback();
    });
    // Show modal  
    $modal.modal('show');       
}