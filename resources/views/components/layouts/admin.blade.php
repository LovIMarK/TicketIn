{{-- Admin layout wrapper: injects admin navigation and renders page content --}}
<x-layouts.app >
    <x-slot:nav>
        @include('partials.nav.admin')
    </x-slot:nav>

    {{ $slot }}
    {{-- Page-level scripts added via @push('scripts') --}}
    @stack('scripts')


</x-layouts.app>
