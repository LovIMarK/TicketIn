<x-layouts.auth>

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <x-layouts.form-input id="name" name="name" label="Name" type="text" required />

            <x-layouts.form-select id="department_id" name="department_id" label="Department" :options="$departments" required />

            <x-layouts.form-input id="email" name="email" label="Email" type="email" required />
            <x-layouts.form-input id="password" name="password" label="Password" type="password" required />
            <x-layouts.form-input id="password_confirmation" name="password_confirmation" label="Confirm Password" type="password" required />

            <button type="submit" class="w-full bg-[#2b1c50] text-white py-2 rounded hover:bg-[#3d2c6e] transition">Register</button>
        </form>
    </div>



</x-layouts.auth>
