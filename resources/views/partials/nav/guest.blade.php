{{-- Guest navigation header --}}
<header class="fixed top-0 left-0 w-full z-50 bg-[#2b1c50] text-white px-6 py-4 shadow flex justify-between items-center">
    <div class="text-2xl font-bold tracking-tight">
        <a href="{{ route('index') }}">{{ config('app.name') }}</a>
    </div>
    <nav class="space-x-4">
        <a href="{{ route('login') }}" class="text-sm hover:text-indigo-300">Login</a>
        <a href="{{ route('register') }}" class="text-sm bg-white text-[#2b1c50] font-semibold px-4 py-2 rounded hover:bg-indigo-300 transition">Sign up</a>
    </nav>
</header>
