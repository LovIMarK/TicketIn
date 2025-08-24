<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\FiltersTickets;


/**
 * Admin ticket management controller.
 *
 * Exposes admin-only endpoints to create, list, view, and update tickets,
 * including posting messages and uploading attachments.
 *
 * Secured by the 'role:admin' middleware.
 */

class TicketController extends Controller
{

    use FiltersTickets;


    /**
     * Register admin-only middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
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
     * Show the admin ticket creation form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createTicket()
    {
        $users = $this->userByName();
        return view('admin.tickets.create', [
            'users' => $users,
        ]);
    }

    /**
     * List tickets for admins with optional filters (via query string).
     *
     * Uses the FiltersTickets trait to apply common filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function tickets(Request $request) {
        $tickets = $this->filteredTickets($request);

        return view('admin.tickets.tickets', [
            'tickets' => $tickets,
            'currentFilter' => $request->query('filter'),
        ]);
    }

    /**
     * Render a compact summary for the given ticket.
     *
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Contracts\View\View
     */
    public function summary(Ticket $ticket)
    {
        return view('admin.tickets.summary', ['ticket' => $ticket]);
    }


    /**
     * Update a ticket.
     *
     * If `update_type=message`, creates a message (and optional attachment) as the
     * authenticated user. Otherwise updates ticket fields (status/priority/agent).
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

            return redirect()->route('admin.tickets.show', $ticket)
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
    * Display ticket details with eager-loaded relations and assignable agents.
    *
    * @param \App\Models\Ticket $ticket
    * @return \Illuminate\Contracts\View\View
    */
    public function show(Ticket $ticket)
    {
        $ticket->load(['user.department', 'agent', 'messages.attachments','messages.user']);
        $agents = User::where('role', 'agent')->get();


        return view('admin.tickets.show', [
            'ticket' => $ticket,
            'agents' => $agents,
        ]);
    }

}
