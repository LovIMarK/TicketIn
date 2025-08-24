<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Ticket;


/**
 * End-user ticket controller.
 *
 * Allows authenticated users (role: user) to create, view, and update
 * their own tickets, and to post messages/attachments on them.
 *
 * Secured by the 'role:user' middleware.
 */
class TicketController extends Controller
{
    /**
     * Register user-only middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:user');
    }

    /**
     * Retrieve the authenticated user's tickets as a paginated list.
     *
     * Ordering:
     * - priority desc
     * - status asc
     * - created_at desc
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTickets()
    {
        return Ticket::where('user_id', Auth::id())
                        ->orderBy('priority', 'desc')
                        ->orderBy('status', 'asc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
    }


    /**
     * Show the ticket creation form for end users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createTicket()
    {
        return view('user.tickets.create', [

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
        $ticket->load(['user.department', 'agent', 'messages.attachments']);
        $agents = User::where('role', 'agent')->get();


        return view('user.tickets.show', [
            'ticket' => $ticket,
            'agents' => $agents,
        ]);
    }


    /**
     * Update a ticket or post a message as the authenticated user.
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

            return redirect()->route('user.tickets.show', $ticket)
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
     * Render the user's ticket list page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function tickets(Request $request) {
        $tickets = $this->getTickets();

        return view('user.tickets.tickets', [
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
        return view('user.tickets.summary', ['ticket' => $ticket]);
    }
}
