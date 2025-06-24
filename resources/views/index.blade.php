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

    </head>
    <body class="antialiased bg-gradient-to-br from-[#2b1c50] to-[#1e103a] text-white">

        <!-- NAVBAR -->
        <header class="fixed top-0 left-0 w-full z-50 bg-[#2b1c50] text-white px-6 py-4 shadow flex justify-between items-center">
            <div class="text-2xl font-bold tracking-tight">
                <a href="{{ route('index') }}">{{ config('app.name') }}</a>
            </div>
            <nav class="space-x-4">
                <a href="{{ route('login') }}" class="text-sm hover:text-indigo-300">Login</a>
                <a href="{{ route('register') }}" class="text-sm bg-white text-[#2b1c50] font-semibold px-4 py-2 rounded hover:bg-[#f0f1ff] transition">Sign up</a>
            </nav>
        </header>

        <!-- HERO -->
        <section class="relative px-6 py-20 text-center overflow-hidden">
            <div class="max-w-3xl mx-auto z-10 relative">
                <h1 class="text-5xl font-extrabold leading-tight mb-6">
                    Simplify Support. <br><span class="text-indigo-300">Deliver Excellence.</span>
                </h1>
                <p class="text-lg text-indigo-100 mb-8">
                    {{config('app.name')}} is the powerful ticketing system your team deserves. <br>
                    Manage issues, collaborate efficiently, and wow your customers.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 text-[#2b1c50] bg-white rounded-lg font-medium hover:bg-[#f0f1ff] transition shadow">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 border border-white text-white rounded-lg font-medium hover:bg-white hover:text-[#2b1c50] transition">
                        Login
                    </a>
                </div>
            </div>

            <!-- BG decorative shapes -->
            <div class="absolute top-0 left-0 w-full h-full z-0 opacity-10 pointer-events-none">
                <div class="w-72 h-72 bg-purple-500 rounded-full blur-3xl absolute -top-20 -left-20"></div>
                <div class="w-96 h-96 bg-indigo-400 rounded-full blur-3xl absolute bottom-0 right-0"></div>
            </div>
        </section>

        <!-- MOCKUP / IMAGE -->
        <section class="px-6 py-12">
            <div class="max-w-5xl mx-auto rounded-2xl overflow-hidden shadow-xl bg-[#f0f1ff]">
                <img src="{{ asset('assets/example_dashboard.png') }}" alt="App screenshot" class="w-full object-cover" />
            </div>
        </section>

        <!-- FEATURES -->
        <section class="bg-[#f0f1ff] text-[#2b1c50] px-6 py-20">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-16">Why teams love {{config('app.name')}}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="text-3xl mb-4">📨</div>
                        <h3 class="text-xl font-semibold mb-2">Smooth Ticketing</h3>
                        <p class="text-gray-600">Create, prioritize and manage support requests in seconds with a clean UI.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="text-3xl mb-4">⚡</div>
                        <h3 class="text-xl font-semibold mb-2">Instant Assignments</h3>
                        <p class="text-gray-600">Smart routing to the right agents or teams. Save time, reduce chaos.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="text-3xl mb-4">📈</div>
                        <h3 class="text-xl font-semibold mb-2">Real-time Analytics</h3>
                        <p class="text-gray-600">Track performance, resolution times, and customer satisfaction instantly.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="text-center text-sm text-gray-400 py-6 mt-10">
            &copy; {{ date('Y') }} {{config('app.name')}}. All rights reserved.
        </footer>

    </body>
</html>
