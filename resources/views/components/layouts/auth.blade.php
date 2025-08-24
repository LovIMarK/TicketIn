{{-- Guest base layout: public-facing pages wrapper --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">


        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        <title> {{config('app.name')}} </title>
    </head>
    <body class="antialiased bg-gradient-to-br from-[#2b1c50] to-[#1e103a] ">

        @include('partials.nav.guest')

        <main class="flex flex-col min-h-screen center items-center justify-center text-#2b1c50">
            {{ $slot }}
        </main>

        @include('partials.footer')
    </body>
</html>
