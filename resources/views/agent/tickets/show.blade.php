<x-layouts.agent>
    <div class="max-w-5xl mx-auto p-6">

        <!-- Ticket Details -->
        <div class="bg-[#2b1c50] text-[#f0f1ff] border border-[#2b1c50] rounded-xl shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">{{ $ticket->title }}</h1>

                <form method="POST" action="{{ route('agent.tickets.update', $ticket) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="meta">

                    <select name="priority"
                        onchange="this.form.submit()"
                        class="appearance-none bg-transparent border-none focus:ring-0 {{ $ticket->priorityBadgeStyle() }}">
                        <option value="" style="color: #2b1c50;" {{ $ticket->priority === null ? 'selected' : '' }}>Not set</option>
                        <option value="low" style="color: #2b1c50;" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" style="color: #2b1c50;" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" style="color: #2b1c50;" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </form>
            </div>

            <div class="text-sm text-gray-300 space-y-1">
                <p>
                    Status:
                    <form method="POST" action="{{ route('agent.tickets.update', $ticket) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_type" value="meta">
                        <select name="status"
                            onchange="this.form.submit()"
                            class="appearance-none bg-transparent border-none focus:ring-0 cursor-pointer {{ $ticket->statusBadgeStyle() }}">
                            <option value="open" style="color: #2b1c50" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" style="color: #2b1c50" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="closed" style="color: #2b1c50" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </form>
                </p>
                <p>Created: {{ $ticket->created_at->format('d M Y H:i') }}</p>
                <p>Last updated: {{ $ticket->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- User & Agent Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="border border-2b1c50 bg-white p-4 rounded shadow">
                <h2 class="font-semibold text-[#2b1c50] mb-2">User</h2>
                <p><strong>Name:</strong> {{ $ticket->user->name }}</p>
                <p><strong>Email:</strong> {{ $ticket->user->email }}</p>
                <p><strong>Department:</strong> {{ $ticket->user->department->name }}</p>
            </div>

            <div class="border border-2b1c50 bg-white p-4 rounded shadow">
                <h2 class="font-semibold text-[#2b1c50] mb-2">Assigned Agent</h2>

                @if ($ticket->agent)
                    <p><strong>Name:</strong> {{ $ticket->agent->name }}</p>
                    <p><strong>Email:</strong> {{ $ticket->agent->email }}</p>

                @else
                    <p class="text-gray-500 italic mb-2">No agent assigned yet.</p>

                    <!-- Dropdown to assign agent -->
                    <form method="POST" action="{{ route('agent.tickets.update', $ticket) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_type" value="meta">
                        <input type="hidden" name="agent_id" value="{{ auth()->id() }}">

                        <button type="submit"
                                class="bg-[#2b1c50] text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Assign Myself
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Initial Message -->
        <div class="border border-[#2b1c50] bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="font-semibold text-lg mb-2">Initial Message</h2>
            <p class="text-[#2b1c50]">{{ $ticket->firstMessage?->content ?? 'No message found.' }}</p>
        </div>

        <!-- Attachments -->
        @if ($ticket->messages->flatMap->attachments->isNotEmpty())
            <div class="border border-2b1c50 bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-lg mb-2">All Attachments</h2>
                <ul class="list-disc list-inside text-sm text-indigo-700">
                    @foreach ($ticket->messages as $message)
                        @foreach ($message->attachments as $file)
                            <li>
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="underline hover:text-indigo-900">
                                    {{ $file->file_name }}
                                </a>
                                <span class="text-xs text-gray-500 ml-2">— Sent: {{ $message->created_at->format('d M Y H:i') }}</span>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Replies -->
        @if ($ticket->messages->count() > 1)
            <div class="border border-[#2b1c50] bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold text-lg mb-4">Replies</h2>
                <div class="space-y-4 text-sm text-gray-700">
                    @foreach ($ticket->messages->skip(1) as $message)
                        <div class="border-l-4 border-indigo-400 pl-4">
                            <p class="mb-1 text-base text-[#2b1c50]">{{ $message->content }}</p>
                            <p class="text-xs text-gray-500">
                                <strong>From:</strong> {{ $message->user->name ?? 'Unknown' }}<br>
                                <span>Sent: {{ $message->created_at->format('d M Y H:i') }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reply Form -->
        <div class="border border-[#2b1c50] bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-lg mb-4">Respond or Update</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 rounded bg-red-100 border border-red-300 text-red-700">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('agent.tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="update_type" value="message">

                <!-- Message -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#2b1c50]">Message</label>
                    <textarea name="content" rows="4" class="w-full p-2 mt-1 border rounded" required></textarea>
                </div>

                <!-- File Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#2b1c50] mb-1">Attachment</label>
                    <input
                        type="file"
                        name="attachment"
                        class="block w-full rounded border border-[#2b1c50] px-4 py-2 text-sm text-[#2b1c50]
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0 file:text-sm file:font-semibold
                            file:bg-[#2b1c50] file:text-white hover:file:bg-indigo-700
                            transition duration-150 ease-in-out"
                    >
                </div>

                <!-- Submit -->
                <button type="submit" class="bg-[#2b1c50] text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Submit
                </button>
            </form>
        </div>
    </div>
</x-layouts.agent>
