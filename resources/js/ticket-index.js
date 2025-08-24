/**
 * Ticket index page interactions.
 *
 * Expects:
 * - <meta name="user-role" content="admin|agent|user">
 * - <select id="filter"> with values used as query params
 * - Ticket list items with class "ticket-item" and a "data-url" attribute
 * - A summary container: <div id="ticketSummary"></div>
 */

/**
 * Fetch and display the summary of a specific ticket in the #ticketSummary panel.
 *
 * Side effects:
 * - Performs a GET request to the provided URL.
 * - Replaces the innerHTML of #ticketSummary with the returned HTML or an error message.
 *
 * @param {string} url - The absolute/relative URL that returns the ticket summary HTML.
 * @returns {void}
 */
function showSummary(url) {
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error("403 or Not Found");
            return response.text();
        })
        .then(html => {
            const summaryPanel = document.getElementById('ticketSummary');
            if (summaryPanel) summaryPanel.innerHTML = html;
        })
        .catch(error => {
            const summaryPanel = document.getElementById('ticketSummary');
            if (summaryPanel) summaryPanel.innerHTML = `<p class="text-red-500">Unable to load summary.</p>`;
            console.error(error);
        });
}

/**
 * Initialize interactions on the ticket index page:
 *
 * - Filter dropdown: navigates to /{role}/tickets?filter={value}
 * - Ticket click: loads summary via AJAX into #ticketSummary
 *
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', function () {
    const role = document.querySelector('meta[name="user-role"]')?.getAttribute('content');
    const filterSelect = document.getElementById('filter');

    // Filter: navigate when a valid option is selected
    if (filterSelect && role) {
        filterSelect.addEventListener('change', function () {
            const filterBy = this.value;
            if (filterBy !== 'Filter by...') {
                window.location.href = `/${role}/tickets?filter=${filterBy}`;
            }
        });
    }

    // Ticket summary: fetch and inject on click
    const tickets = document.querySelectorAll('.ticket-item');
    tickets.forEach(ticket => {
        ticket.addEventListener('click', () => {
            const url = ticket.getAttribute('data-url');
            if (url) showSummary(url);
        });
    });
});

