<x-layouts.auth>

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <x-layouts.form-input id="email" name="email" label="Email" type="email" required />
            <x-layouts.form-input id="password" name="password" label="Password" type="password" required  />

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="form-checkbox h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                    <label for="remember" class="ml-3 block text-sm leading-6 text-gray-900">remember me</label>
                </div>
            </div>

        <button type="submit" class="w-full bg-[#2b1c50] text-white py-2 rounded hover:bg-[#3d2c6e] transition">Login</button>
    </div>
</x-layouts.auth>
