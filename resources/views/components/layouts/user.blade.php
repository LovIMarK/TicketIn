{{-- User layout wrapper: injects user navigation and renders page content --}}
<x-layouts.app>
    <x-slot:nav>
        @include('partials.nav.user')
    </x-slot:nav>

    {{ $slot }}

</x-layouts.app>
