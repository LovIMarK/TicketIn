<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

/**
 * Admin dashboard metrics aggregator.
 *
 * Computes weekly ticket KPIs for the admin view:
 * - Unassigned tickets
 * - Average first response time (minutes)
 * - Average resolution time (hours)
 * - Tickets created this week and status breakdown
 * - Top agents by resolved/closed tickets
 * Also builds a 7-day volume series for charting.
 */

class DashboardController extends Controller
{

    /**
     * Render the admin dashboard with weekly KPIs and 7-day volume series.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $now = Carbon::now();
        $weekStart = $now->copy()->startOfWeek();
        $weekEnd = $now->copy()->endOfWeek();

        $unassignedTickets = Ticket::whereNull('agent_id')->count();

        $averageFirstResponseTime = DB::table('tickets')
            ->join('messages', 'tickets.id', '=', 'messages.ticket_id')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, tickets.created_at, messages.created_at)) as avg_response_time'))
            ->whereRaw('messages.user_id != tickets.user_id')
            ->groupBy('tickets.id')
            ->value('avg_response_time');

        $averageResolutionTime = Ticket::whereNotNull('closed_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, closed_at)) as avg_resolution_time'))
            ->value('avg_resolution_time');

        $ticketsThisWeek = Ticket::whereBetween('created_at', [$weekStart, $weekEnd])->count();

        $statusCounts = Ticket::whereBetween('created_at', [$weekStart, $weekEnd])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $topAgents = User::select('users.id', 'users.name', DB::raw('COUNT(tickets.id) as tickets_count'))
            ->join('tickets', 'users.id', '=', 'tickets.agent_id')
            ->whereBetween('tickets.created_at', [$weekStart, $weekEnd])
            ->whereIn('tickets.status', ['resolved', 'closed'])
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('tickets_count')
            ->take(10)
            ->get();

        $period = CarbonPeriod::create(now()->subDays(6), now());
        $ticketVolumeData = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($period as $date) {
            $label = $date->format('d M');
            $count = Ticket::whereDate('created_at', $date)->count();
            $ticketVolumeData['labels'][] = $label;
            $ticketVolumeData['data'][] = $count;
        }

        $averageFirstResponseTime = $averageFirstResponseTime ? round($averageFirstResponseTime / 60) : 0;
        $averageResolutionTime = $averageResolutionTime ? round($averageResolutionTime / 3600) : 0;

        return view('admin.dashboard', [
            'unassignedTickets' => $unassignedTickets,
            'averageFirstResponseTime' => $averageFirstResponseTime,
            'averageResolutionTime' => $averageResolutionTime,
            'ticketsThisWeek' => $ticketsThisWeek,
            'statusCounts' => $statusCounts,
            'topAgents' => $topAgents,
            'ticketVolumeData' => $ticketVolumeData,
        ]);
    }
}
