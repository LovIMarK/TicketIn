{{-- Agent primary navigation header --}}
<header class="flex justify-between items-center px-6 py-4 bg-[#2b1c50] text-white shadow">
    <div class="text-2xl font-bold tracking-tight">
        <a href="{{ route('index') }}">{{ config('app.name') }}</a>
    </div>
    <nav class="space-x-4">
        <a href="{{ route('agent.home')}}" class="hover:underline">Tickets</a>
        <a href="{{ route('agent.tickets.create') }}" class="hover:underline">Create Ticket</a>

        {{-- Logout triggers a POST via hidden form to protect against CSRF --}}
        <a href="#" class="hover:underline"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
        Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</header>
