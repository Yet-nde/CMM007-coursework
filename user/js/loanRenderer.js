(function ($) {
    // Render loans table
    function renderLoans(loans) {
        if (!loans || loans.length === 0) {
            $('#loansTableBody').html('<tr><td colspan="7">No books currently borrowed</td></tr>');
            return;
        }

        const $tbody = $('<tbody>');
        loans.forEach(loan => {
            const $row = $('<tr>');
            $row.append($('<td>').text(loan.title));
            $row.append($('<td>').text(loan.author));
            $row.append($('<td>').text(loan.borrow_date));
            $row.append($('<td>').text(loan.due_date));
            $row.append($('<td>').text(loan.return_date || 'Not returned'));

            const $statusBadge = $('<span>')
                .addClass('badge ' + window.statusHelper.getStatusBadgeClass(loan.status))
                .text(loan.status);
            $row.append($('<td>').append($statusBadge));

            if (loan.status === 'borrowed') {
                const $returnBtn = $('<button>')
                    .addClass('btn btn-sm btn-info return-btn')
                    .text('Return')
                    .data('loan-id', loan.loan_id)

                $row.append($('<td>').append($returnBtn));
            } else {
                $row.append($('<td>'));
            }

            $tbody.append($row);
        });
        $('#loansTableBody').empty().append($tbody.children());
    }

    // Load user loans
    function loadLoans() {
        $.getJSON('/CMM007-coursework/user/controllers/getBorrowedBooks.php', function (response) {
            if (response.status === 'success') {
                renderLoans(response.data);
            }
        });
    }

    // Make functions available globally
    window.loanRenderer = {
        renderLoans,
        loadLoans
    };
})(jQuery);