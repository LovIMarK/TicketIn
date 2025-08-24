<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Http\Controllers\Traits\FiltersTickets;

/**
 * Agent ticket management controller.
 *
 * Provides agent-only endpoints to list, view, update, and comment on tickets.
 * Secured by the 'role:agent' middleware.
 */
class TicketController extends Controller
{

    use FiltersTickets;

    /**
     * Register agent-only middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:agent');
    }


    /**
     * Get paginated tickets prioritizing unassigned and unprioritized ones.
     *
     * Orders by:
     * - unassigned first (agent_id IS NULL)
     * - missing priority first (priority IS NULL)
     * - newest first (created_at desc)
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function nonAssignedTickets()
    {
        return Ticket::orderByRaw('agent_id IS NULL DESC')
                    ->orderByRaw('priority IS NULL DESC')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
    }


    /**
     * Render a compact summary for the given ticket.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function summary(Ticket $ticket)
    {
        return view('agent.tickets.summary', ['ticket' => $ticket]);
    }

    /**
     * Get all users ordered by name (ascending).
     *
     * @return \Illuminate\Database\Eloquent\Collection<int,\App\Models\User>
     */
    private function userByName()
    {
        $users = User::orderBy('name', 'asc')->get();
        return $users;
    }

    /**
     * Show the ticket creation form for agents.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createTicket()
    {
        $users = $this->userByName();
        return view('agent.tickets.create', [
            'users' => $users,
        ]);
    }


    /**
     * Update a ticket or post a message as the authenticated agent.
     *
     * If `update_type=message`, creates a ticket message (and optional attachment).
     * Otherwise updates ticket fields (status/priority/agent).
     *
     * Validation:
     * - content required when posting a message
     * - attachment optional; jpg/jpeg/png/pdf/doc/docx; max 6 MB
     * - status in: open|closed|in_progress
     * - priority in: low|medium|high
     * - agent_id must exist in users
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Ticket $ticket)
    {

        if ($request->input('update_type') === 'message') {
            $validated = $request->validate([
                'content' => 'required|string',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:6000',
            ]);


            $message = $ticket->messages()->create([
                'user_id' => Auth::id(),
                'content' => $validated['content'],
            ]);


            if ($request->hasFile('attachment')) {
                $message->attachments()->create([
                    'file_name' => $request->file('attachment')->getClientOriginalName(),
                    'file_path' => $request->file('attachment')->store('attachments', 'public'),
                    'file_type' => $request->file('attachment')->getClientMimeType(),
                ]);
            }

            return redirect()->route('agent.tickets.show', $ticket)
                ->with('success', 'Message and attachment added.');

        }
        $validated = $request->validate([
            'status' => 'nullable|string|in:open,closed,in_progress',
            'priority' => 'nullable|string|in:low,medium,high',
            'agent_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update(array_filter($validated));

        return back()->with('success', 'Ticket updated.');


    }

     /**
     * List tickets for agents with optional filters (via query string).
     *
     * Uses the FiltersTickets trait to apply common filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function tickets(Request $request) {
        $tickets = $this->filteredTickets($request);

        return view('agent.tickets.tickets', [
            'tickets' => $tickets,
            'currentFilter' => $request->query('filter'),
        ]);
    }

    /**
     * Display ticket details with eager-loaded relations and assignable agents.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Ticket $ticket)
    {
        // Load the necessary relationships for the ticket
        $ticket->load(['user.department', 'agent', 'messages.attachments']);
        // Get the agents to assign to the ticket
        $agents = User::where('role', 'agent')->get();


        return view('agent.tickets.show', [
            'ticket' => $ticket,
            'agents' => $agents,
        ]);
    }

}
