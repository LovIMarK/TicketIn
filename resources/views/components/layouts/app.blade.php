{{-- Base application layout: loads assets, optional nav slot, flash status, and page content --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="user-role" content="{{ Auth::user()->role }}">


        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @vite('resources/js/ticket-index.js')
        @vite('resources/js/dashboard.js')

        <title> {{config('app.name')}} </title>
    </head>
    <body class="flex flex-col min-h-screen bg-[#f0f1ff] text-[#2b1c50] antialiased">
        {{-- Optional navigation slot --}}
        {{ $nav ?? '' }}

        @if (session('status'))
        <div class="mt-10 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                </div>
            </div>
        </div>

        @endif

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">

        {{ $slot }}
        </main>

        @include('partials.footer')
    </body>
</html>
