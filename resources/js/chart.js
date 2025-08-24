import Chart from 'chart.js/auto';


/**
 * Render the weekly ticket volume chart.
 *
 * Expects a <canvas id="ticketVolumeChart"> element to be present in the DOM.
 * The chart is not memoized; calling this multiple times will create multiple instances.
 * (Consider storing and destroying a previous instance if you re-render.)
 *
 * @param {string[]} labels - X-axis labels (e.g., formatted dates '12 Aug').
 * @param {number[]} data   - Y-axis values (ticket counts per label).
 * @returns {void}
 */
export function renderTicketVolumeChart(labels, data) {
    const canvas = document.getElementById('ticketVolumeChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    /* Chart configuration:
        - Line chart with a subtle fill
        - Legend hidden (single series)
        - Y axis starts at 0 with integer tick steps
    */
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Tickets',
                data: data,
                borderColor: '#2b1c50',
                backgroundColor: 'rgba(43, 28, 80, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#6b7280'
                    }
                },
                x: {
                    ticks: { color: '#6b7280' }
                }
            }
        }
    });
}
