document.addEventListener("DOMContentLoaded", function () {
    // Helper function to get the status class
    function getStatusClass(status) {
        const statusClasses = {
            'PENDING': 'badge-warning',
            'APPROVED': 'badge-success',
            'REJECTED': 'badge-danger'
        };
        return statusClasses[status] || 'badge-secondary';
    }
});