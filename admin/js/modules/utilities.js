export function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
};

// Helper for status badge
export function getStatusBadge(status) {
    const badgeClasses = {
        pending: 'bg-light',
        active: 'bg-info',
        suspended: 'bg-warning',
        deleted: 'bg-danger'
    };
    const formattedStatus = status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();
    return `<span class="badge ${badgeClasses[status]}" style="text-transform: none;">${formattedStatus}</span>`;
}

// Helper for CSRF token retrieval
export function getCsrfToken() {
    return document.querySelector('input[name="csrf_token"]')?.value;
}