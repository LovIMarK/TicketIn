<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Http\Controllers\Traits\RedirectsByRole;


use Illuminate\Http\Request;

/**
 * Ticket creation controller.
 *
 * Handles ticket submission from authenticated users, creates the initial
 * message, optionally stores an attachment, and redirects based on role.
 * Secured by the 'auth' middleware.
 */
class TicketController extends Controller
{

    use RedirectsByRole;
    /**
     * Register auth middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Validate input, create a new ticket with an initial message,
     * optionally attach a file, then redirect by role.
     *
     * Validation rules:
     * - title: required|string|max:255
     * - content: required|string
     * - attachment: nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048 (≈2 MB)
     * - user_id: nullable|exists:users,id (only used by admin/agent)
     *
     * Behavior:
     * - For roles 'admin' and 'agent', the ticket can be opened on behalf of
     *   another user when `user_id` is provided; otherwise uses the current user.
     * - Persists the ticket and its first message; stores the attachment on the
     *   'public' disk under 'attachments' if provided.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();  ;
        $userId = match ($user->role) {
            'admin', 'agent' => $validated['user_id'] ?? $user->id,
            default          => $user->id,
        };

        try {
            $ticket = Ticket::create([
                'title' => $validated['title'],
                'uuid' => \Illuminate\Support\Str::uuid(),
                'user_id' => $userId,
                'status' => 'open',
                'priority' => null,
            ]);


            $message = $ticket->messages()->create([
                'user_id' => $userId,
                'content' => $validated['content'],
            ]);

            if ($request->hasFile('attachment')) {
                $this->handleAttachment($request->file('attachment'), $message);
            }

            return redirect()->intended($this->redirectByRole(Auth::user()))
                ->with('success', 'Ticket created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create ticket: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Store an uploaded attachment for a ticket message.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param \App\Models\Message $message
     * @return void
     */
    private function handleAttachment($file, Message $message): void
    {
        $message->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $file->store('attachments', 'public'),
            'file_type' => $file->getClientMimeType(),
        ]);
    }

}
