(function ($) {
    // Borrow book function
    function borrowBook(bookId) {
        window.confirmationModal.showConfirmation("Are you sure you want to borrow this book?", () => {
            $('#bookDetailsModal').modal('hide');
            performBorrow(bookId);
        });
    }

    function performBorrow(bookId) {
        $.ajax({
            url: '/CMM007-coursework/user/controllers/borrowBook.php',
            type: 'POST',
            data: {
                book_id: bookId,
                csrf_token: $('input[name="csrf_token"]').val()
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    window.toastNotification.showToast('success', response.message);
                    // Update borrow count
                    $('#currentBorrowCount').text(response.currentCount);
                    // Reload books to update availability
                    window.bookRenderer.loadFilteredBooks({});
                } else {
                    window.toastNotification.showToast('danger', response.message);
                }
            },
            error: function (xhr) {
                window.toastNotification.showToast('danger', 'Network error - Please try again.');
                console.error('Borrow error:', xhr.responseText);
            }
        });
    }

    // Return book function
    function returnBook(loanId) {
        window.confirmationModal.showConfirmation("Are you sure you want to return this book?", () => {
            performReturn(loanId);
        });
    }

    function performReturn(loanId) {
        const $btn = $(`.return-btn[data-loan-id="${loanId}"]`);
        const $row = $btn.closest('tr');

        // usual feedback
        $btn.addClass('disabled pe-none')
            .html('<span class="spinner-border spinner-border-sm me-2"></span> Returning');

        $.ajax({
            url: '/CMM007-coursework/user/controllers/returnBook.php',
            type: 'POST',
            data: {
                loan_id: loanId,
                csrf_token: $('input[name="csrf_token"]').val()
            },
            dataType: 'json',
            success: function (response) {
                console.log('Return Response:', response);

                if (response.status === 'success') {
                    // Remove the row immediately
                    $row.fadeOut(400, function () {
                        $(this).remove();
                    });

                    // Show success message
                    window.toastNotification.showToast('success', response.message);

                    // Update counters and refresh book list
                    updateBorrowCount();
                    window.bookRenderer.loadFilteredBooks({});

                    // Refresh the loans table
                    if ($('#loans').hasClass('active')) {
                        window.loanRenderer.loadLoans();
                    }
                } else {
                    resetReturnButton($btn);
                    window.toastNotification.showToast('danger', response.message);
                }
            },
            error: function (xhr) {
                resetReturnButton($btn);
                console.error('Return Error:', xhr.responseText);
                window.toastNotification.showToast('danger', 'Network error - please try again');
            }
        });
    }

    // Helper function to reset button state
    function resetReturnButton($btn) {
        $btn.removeClass('disabled pe-none')
            .html('Return');
    }

    // Update borrow count
    function updateBorrowCount() {
        $.getJSON('/CMM007-coursework/user/controllers/getBorrowedBooks.php', function (data) {
            if (data.currentCount !== undefined) {
                $('#currentBorrowCount').text(data.currentCount);
            }
        }).fail(function () {
            console.error('Error updating borrow count');
        });
    }

    // Make functions available globally
    window.bookService = {
        borrowBook,
        returnBook,
        updateBorrowCount
    };
})(jQuery);