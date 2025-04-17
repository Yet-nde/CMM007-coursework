(function ($) {
    // Initialize Page
    $(function () {
        window.bookRenderer.initFilters();
        window.bookRenderer.loadFilteredBooks({});
        window.bookService.updateBorrowCount();

        // Event listeners for filters
        $('#genreFilter, #sortFilter, #availabilityFilter').change(function () {
            window.bookRenderer.loadFilteredBooks({});
        });

        // Search button click handler
        $('#userPageSearchBtn').click(function () {
            window.bookRenderer.loadFilteredBooks({});
        });

        // Search on pressing Enter
        $('#userPageSearch').keypress(function (e) {
            if (e.which === 13) { // Enter key
                window.bookRenderer.loadFilteredBooks({});
            }
        });
        // Event handlers:
        $(document).off('click', '.return-btn').on('click', '.return-btn', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();


            const $btn = $(this);
            if ($btn.hasClass('processing')) return;

            const loanId = $btn.data('loan-id');
            $btn.addClass('processing');
            window.bookService.returnBook(loanId);
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            if (e.target.id === 'loans-tab') {
                // Add slight delay to ensure tab is ready
                setTimeout(window.loanRenderer.loadLoans, 50);
            } else if (e.target.id === 'search-tab') {
                if (!document.getElementById('userPageSearch').value.trim()) {
                    window.bookRenderer.loadFilteredBooks({});
                }
            }
        });

        // Ensure modal focus management
        $('#bookDetailsModal').on('hidden.bs.modal', function () {
            // Make sure focus moves away from the modal and add inert when hidden
            $(this).find('.modal-content').attr('inert', true);
        });

        $('#bookDetailsModal').on('shown.bs.modal', function () {
            // Remove inert and allow focus to return
            $(this).find('.modal-content').removeAttr('inert');
        });
    });
})(jQuery);