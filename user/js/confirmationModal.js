(function ($) {
    // Confirmation system
    function showConfirmation(message, confirmCallback) {
        const $modal = $('#confirmationModal');
        const $message = $('#confirmationMessage');
        const $confirmBtn = $('#confirmActionBtn');

        $confirmBtn.off('click');
        $message.text(message);
        $modal.modal('show');

        $confirmBtn.on('click', function() {
            $modal.modal('hide');
            confirmCallback();
        });
    }

    // Make function available globally
    window.confirmationModal = {
        showConfirmation
    };
})(jQuery);