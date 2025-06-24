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
    <body class="bg-[#f0f1ff] text-[#2b1c50] antialiased">

        <!-- Header -->
        <header class="flex justify-between items-center px-6 py-4 bg-[#2b1c50] text-white shadow">
            <h1 class="text-xl font-bold">TicketIn</h1>
            <nav class="space-x-4">
            </nav>
        </header>

        <!-- Main Content -->
        <p>exemple login page</p>
    </body>
</html>
