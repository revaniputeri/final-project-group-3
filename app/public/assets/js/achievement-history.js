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

    // function updateSearch(query) {
    //     const url = new URL(window.location.href);
    //     if (query) {
    //         url.searchParams.set('search', query);
    //     } else {
    //         url.searchParams.delete('search');
    //     }
    //     window.location.href = url.toString();
    // }
});