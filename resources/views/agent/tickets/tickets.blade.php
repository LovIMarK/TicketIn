<x-layouts.agent>
    <!-- Main Content -->
    <main class="flex h-[calc(100vh-64px)] overflow-hidden">

        <!-- tickets list -->
        <section class="w-1/3 border-r border-gray-400 overflow-y-auto p-4">
            <div class="mb-4">

                <select id="filter" class="w-full p-2 border rounded">
                    <option>Filter by...</option>
                    <option value="priority">Priority</option>
                    <option value="date">Creation Date</option>
                    <option value="status">Status</option>
                </select>
            </div>

            <ul id="ticketList">
                @forelse($tickets as $ticket)
                    <li class="ticket-item relative bg-[#2b1c50] text-[#f0f1ff] rounded shadow mb-3 p-3 cursor-pointer hover:bg-indigo-800/30 transition-colors"
                        data-url="{{ route('agent.tickets.summary', $ticket) }}">

                        <!-- Dot top left-->
                        <span class="{{ $ticket->priorityDotStyle() }} absolute top-2 left-2"></span>

                        <h3 class="font-semibold ml-6">{{ $ticket->title }}</h3>

                        <div class="flex items-center gap-2 text-sm text-white/70 ml-6 mt-1">
                            <span class="font-medium">Status:</span>
                            <span class="{{ $ticket->statusBadgeStyle() }}">{{ ucfirst($ticket->status) }}</span>
                        </div>

                        <p class="text-xs text-gray-400 ml-6">{{ $ticket->created_at->format('d M Y') }}</p>
                    </li>
                @empty
                    <li class="text-center text-sm text-gray-500 italic mt-10">
                        No tickets found for now.
                    </li>
                @endforelse
            </ul>
            <!-- Pagination -->
            <div class="mt-4 flex justify-center">
                {{ $tickets->links() }}
            </div>
        </section>

        <!-- Résumé ticket (section à droite) -->
        <section class="w-2/3 bg-[#f0f1ff] text-[#2b1c50] p-6 overflow-auto" id="ticketSummary">
            <p class="text-center text-gray-500">Select a ticket to see the summary.</p>
        </section>
    </main>
</x-layouts.agent>

