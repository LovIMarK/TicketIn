{{--
  Admin Dashboard View

  Expects (from controller):
  - $averageFirstResponseTime (int, minutes)
  - $averageResolutionTime   (int, hours)
  - $unassignedTickets       (int)
  - $ticketsThisWeek         (int)
  - $statusCounts            (array|Collection<string,int>) counts for: open, in_progress, resolved, closed
  - $topAgents               (Collection<{ id:int, name:string, tickets_count:int }>)
  - $ticketVolumeData        (array{ labels: string[], data: int[] }) for Chart.js

--}}

<x-layouts.admin>
    <div class="p-6 bg-[#f0f1ff] min-h-screen space-y-8">

        {{-- KPI Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <div class="text-3xl font-bold text-[#2b1c50]">{{ $averageFirstResponseTime }}<span class="text-base">m</span></div>
                <div class="text-sm mt-2 text-gray-500 uppercase">First response time</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <div class="text-3xl font-bold text-[#2b1c50]">{{ $averageResolutionTime }}<span class="text-base">h</span></div>
                <div class="text-sm mt-2 text-gray-500 uppercase">Full resolution time</div>
            </div>

            <div class="bg-red-100 p-6 rounded-xl shadow text-center">
                <div class="text-3xl font-bold text-red-600">{{ $unassignedTickets }}</div>
                <div class="text-sm mt-2 text-red-600 uppercase">Unassigned tickets</div>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Tickets by status --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-sm uppercase text-gray-500 mb-4">Tickets by status (this week)</h2>

                @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                    @php
                        $label = ucwords(str_replace('_', ' ', $status));
                        $count = $statusCounts[$status] ?? 0;
                        $percent = $ticketsThisWeek > 0 ? ($count * 100 / $ticketsThisWeek) : 0;
                    @endphp
                    <div class="mb-4">
                        <div class="text-sm font-medium text-[#2b1c50] mb-1">{{ $label }}</div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ $count }} tickets</div>
                    </div>
                @endforeach
            </div>

            {{-- Top agents --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-sm uppercase text-gray-500 mb-4">Top ticket solvers (this week)</h2>
                <table class="w-full text-sm text-left text-[#2b1c50]">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-2">Agent</th>
                            <th class="py-2 text-right">Tickets resolved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topAgents as $agent)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2">{{ $agent->name }}</td>
                                <td class="py-2 text-right">{{ $agent->tickets_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-3 text-center text-gray-400">No resolved tickets this week</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Chart: Volume this week --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-sm uppercase text-gray-500 mb-4">Ticket volume this week</h2>
            <canvas id="ticketVolumeChart" height="100"></canvas>
        </div>
    </div>

    {{-- Chart.js --}}
    @push('scripts')
    <script>
        window.ticketVolumeData = {
            labels: {!! json_encode($ticketVolumeData['labels']) !!},
            data: {!! json_encode($ticketVolumeData['data']) !!}
        };
    </script>

    @endpush
</x-layouts.admin>
