(function ($) {
    // Toast notification function
    function showToast(type, message) {
        const toast = `<div class="toast align-items-center text-white bg-${type} border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`;

        $('#toastContainer').append(toast);
        setTimeout(() => $('.toast').remove(), 5000);
    }

    // Make function available globally
    window.toastNotification = {
        showToast
    };
})(jQuery);