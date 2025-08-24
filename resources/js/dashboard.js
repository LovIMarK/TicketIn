import { renderTicketVolumeChart } from './chart';

/**
 * Initialize the ticket volume chart when the DOM is ready.
 *
 * Expects the backend to inject a global object:
 *   window.ticketVolumeData = { labels: string[], data: number[] }
 *
 * Notes:
 * - If the payload is missing, the function exits quietly.
 * - Rendering is delegated to renderTicketVolumeChart().
 */
document.addEventListener('DOMContentLoaded', () => {
  /** @type {{ labels: string[], data: number[] } | undefined} */
  const payload = window.ticketVolumeData;

  if (!payload) return;

  renderTicketVolumeChart(payload.labels, payload.data);
});
