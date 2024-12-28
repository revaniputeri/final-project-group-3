document.addEventListener("DOMContentLoaded", function () {
    // Helper function to get the status class
    function getStatusClass(status) {
        const statusClasses = {
            'PROSES': 'badge-warning',
            'DITERIMA': 'badge-success',
            'DITOLAK': 'badge-danger'
        };
        return statusClasses[status] || 'badge-secondary';
    }
});