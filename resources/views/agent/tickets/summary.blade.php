<div class="relative bg-white text-[#2b1c50] p-6 rounded-xl shadow-xl border border-[#2b1c50]">

    <!-- Priority dot (top left) -->
    <span class="{{ $ticket->priorityDotStyle() }} absolute top-4 left-4"></span>

    <!-- Title -->
    <h2 class="text-2xl font-bold mb-4 pl-6">{{ $ticket->title }}</h2>

    <!-- Description -->
    <p class="mb-4 pl-6 text-sm text-[#2b1c50]/80">{{ $ticket->firstMessage?->content }}</p>

    <!-- Details -->
    <div class="space-y-2 text-sm pl-6">
        <div class="flex items-center gap-2">
            <span class="font-medium">Status:</span>
            <span class="{{ $ticket->statusBadgeStyle() }}">{{ ucfirst($ticket->status) }}</span>
        </div>

        <div class="flex items-center gap-2">
            <span class="font-medium">Priority:</span>
            @if($ticket->priority)
                <span class="{{ $ticket->priorityBadgeStyle() }}">{{ ucfirst($ticket->priority) }}</span>
            @else
                <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-xs">Not set</span>
            @endif
        </div>

        <p><span class="font-medium">Last Updated:</span> {{ $ticket->updated_at->format('d M Y') }}</p>
        <p><span class="font-medium">Created:</span> {{ $ticket->created_at->format('d M Y') }}</p>
    </div>

    <!-- CTA -->
    <div class="mt-6 pl-6">
        <a href="{{ route('agent.tickets.show', $ticket) }}"
           class="inline-block px-5 py-2 bg-[#2b1c50] text-white rounded hover:bg-indigo-700 transition">
            Open Full Ticket
        </a>
    </div>
</div>
