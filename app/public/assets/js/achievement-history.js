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

// Debounce function to delay the AJAX request
function debounce(func, delay) {
    let timeoutId;
    return function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, arguments), delay);
    };
}

// AJAX function to fetch achievements based on search query
function fetchAchievements(query, status, start, end) {
    $.ajax({
        url: '/dashboard/achievement/history',
        type: 'GET',
        data: {
            search: query,
            status: status,
            start: start,
            end: end
        },
        dataType: 'json',
        success: function (response) {
            $('#achievementTable tbody').html(response.html);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching achievements:', error);
        }
    });
}

// Attach keyup event to search input
$('#searchInput').on('keyup', debounce(function () {
    var query = $(this).val();
    var status = $('#statusFilterDropdown').find('.dropdown-toggle').text().replace('Status: ', '');
    var start = $('#periodFilterDropdown').find('.dropdown-toggle').text().match(/(\d{4}\/\d{4} \w+)/) ? RegExp.$1 : null;
    var end = null; // Implement if needed

    fetchAchievements(query, status, start, end);
}, 300));