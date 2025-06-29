/**
 * Displays the summary of a specific ticket on the ticket index page.
 * Fetches the summary HTML from the server and injects it into the summary panel.
 *
 * @param {string} ticketId - The ID of the ticket to show the summary for.
 * @returns {void}
 */
function showSummary(ticketId) {
    fetch(`/tickets/${ticketId}/summary`)
        .then(response => response.text())
        .then(html => {
            const summaryPanel = document.getElementById('ticketSummary');
            if (summaryPanel) summaryPanel.innerHTML = html;
        });
}

/**
 * Initializes the ticket index page.
 *
 * - Sets up the filter dropdown to reload the page based on the selected filter.
 * - Attaches click event listeners to each ticket item to load and display its summary dynamically.
 *
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', function () {
    const filterSelect = document.getElementById('filter');
    if (filterSelect) {
        filterSelect.addEventListener('change', function () {
            const filterBy = this.value;
            window.location.href = `/tickets?filter=${filterBy}`;
        });
    }

    // Attach click listeners to ticket items
    const tickets = document.querySelectorAll('.ticket-item');
    tickets.forEach(ticket => {
        ticket.addEventListener('click', () => {
            const id = ticket.getAttribute('data-id');
            if (id) showSummary(id);
        });
    });
});
