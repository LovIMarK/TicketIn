<x-layouts.admin>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-[#2b1c50] mb-6">Create New User</h1>
        <div class="bg-white p-6 rounded-lg shadow-md border">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <x-layouts.form-input label="Name" name="name" required />

                {{-- Email --}}
                <x-layouts.form-input label="Email" name="email" type="email" required />

                {{-- Password --}}
                <x-layouts.form-input label="Password" name="password" type="password" required />

                {{-- Confirm Password --}}
                <x-layouts.form-input label="Confirm Password" name="password_confirmation" type="password" required />

                {{-- Role --}}
                <x-layouts.form-select
                    label="Role"
                    name="role"
                    :options="['user' => 'User', 'agent' => 'Agent', 'admin' => 'Admin']"
                    required
                />

                {{-- Department --}}
                <x-layouts.form-select
                    label="Department"
                    name="department_id"
                    :options="$departments"
                    required
                />

                <div class="mt-6">
                    <button type="submit" class="bg-[#2b1c50] text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
