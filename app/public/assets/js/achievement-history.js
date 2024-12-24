document.addEventListener("DOMContentLoaded", function () {
    const periodDropdown = document.getElementById("periodFilterDropdown");
    const achievementTableBody = document.querySelector(".table tbody");

    // Add event listener to the dropdown menu items
    const dropdownItems = document.querySelectorAll(".dropdown-menu .dropdown-item");
    dropdownItems.forEach(item => {
        item.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default link behavior

            const selectedPeriod = this.getAttribute("href").split("=")[1]; // Extract the period from the href

            // Make an AJAX request to fetch the updated data
            fetch(`/achievement/history?period=${encodeURIComponent(selectedPeriod)}`, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest" // Ensure this header is set
                }
            })
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    // Clear the current table body
                    achievementTableBody.innerHTML = "";

                    // Populate the table with the new data
                    data.achievements.forEach(achievement => {
                        const row = document.createElement("tr");

                        // Add table cells for each column
                        row.innerHTML = `
                            <td>${new Date(achievement.CreatedAt).toLocaleDateString()}</td>
                            <td>${new Date(achievement.UpdatedAt).toLocaleDateString()}</td>
                            <td class="truncate-text">${achievement.CompetitionTitle}</td>
                            <td class="truncate-text">${achievement.CompetitionPlace}</td>
                            <td>${achievement.CompetitionRankName}</td>
                            <td>${achievement.CompetitionLevelName}</td>
                            <td>
                                <label class="badge ${getStatusClass(achievement.AdminValidationStatus)}">
                                    ${achievement.AdminValidationStatus}
                                </label>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/dashboard/achievement/view/${achievement.Id}" class="btn btn-info btn-sm" title="View">
                                        <i class="ti-eye"></i>
                                    </a>
                                    ${achievement.AdminValidationStatus === 'APPROVED'
                                ? '<a href="#" class="btn btn-warning btn-sm disabled" title="Edit" aria-disabled="true"><i class="ti-pencil"></i></a>'
                                : `<a href="/dashboard/achievement/edit/${achievement.Id}" class="btn btn-warning btn-sm" title="Edit"><i class="ti-pencil"></i></a>`
                            }
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete(${achievement.Id})">
                                        <i class="ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        `;

                        // Append the row to the table body
                        achievementTableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        });
    });

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