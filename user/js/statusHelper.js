(function ($) {
    // Helper for loan status badge
    function getStatusBadgeClass(status) {
        switch (status) {
            case 'overdue': return 'bg-danger';
            case 'borrowed': return 'bg-info';
            case 'returned': return 'bg-success';
            default: return 'bg-secondary';
        }
    }

    // Make function available globally
    window.statusHelper = {
        getStatusBadgeClass
    };
})(jQuery);