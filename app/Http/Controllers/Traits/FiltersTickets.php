<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Http\Request;
use App\Models\Ticket;

/**
 * Shared ticket filtering helpers.
 *
 * Provides a reusable query builder that applies common sorting and filtering
 * to ticket listings based on a simple `filter` query parameter.
 */
trait FiltersTickets
{
    /**
     * Build a paginated ticket list using a lightweight `filter` switch.
     *
     * Supported filters:
     * - 'priority': order by priority (desc), then newest first; excludes 'closed'
     * - 'status'  : order by status (asc), then newest first
     * - 'date' or default: newest first; excludes 'closed'
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filteredTickets(Request $request)
    {
        $filter = $request->query('filter');
        $query = Ticket::query();

        switch ($filter) {
            case 'priority':
                $query->orderBy('priority', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->where('status', '!=', 'closed');
                break;
            case 'status':
                $query->orderBy('status', 'asc')
                      ->orderBy('created_at', 'desc');
                break;
            case 'date':
            default:
                $query->orderBy('created_at', 'desc')
                      ->where('status', '!=', 'closed');
        }

        return $query->paginate(10);
    }
}
