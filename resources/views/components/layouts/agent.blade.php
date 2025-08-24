{{-- Agent layout wrapper: injects agent navigation and renders page content --}}
<x-layouts.app >
    <x-slot:nav>
        @include('partials.nav.agent')
    </x-slot:nav>

    {{ $slot }}

</x-layouts.app>
