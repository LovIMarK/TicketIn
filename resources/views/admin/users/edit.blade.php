<x-layouts.admin>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-[#2b1c50] mb-6">Edit User</h1>

        <div class="bg-white p-6 rounded-lg shadow-md border">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <x-layouts.form-input
                    label="Name"
                    name="name"
                    :value="old('name', $user->name)"
                    required
                />

                {{-- Email --}}
                <x-layouts.form-input
                    label="Email"
                    name="email"
                    type="email"
                    :value="old('email', $user->email)"
                    required
                />

                {{-- Role --}}
                <x-layouts.form-select
                    label="Role"
                    name="role"
                    :options="$roles"
                    :selected="old('role', $user->role)"
                    required
                />

                {{-- Department --}}
                <x-layouts.form-select
                    label="Department"
                    name="department_id"
                    :options="$departments"
                    :selected="old('department_id', $user->department_id)"
                    required
                />

                {{-- New Password (optional) --}}
                <x-layouts.form-input
                    label="New Password (optional)"
                    name="password"
                    type="password"
                />

                {{-- Confirm Password --}}
                <x-layouts.form-input
                    label="Confirm Password"
                    name="password_confirmation"
                    type="password"
                />

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:underline">← Back</a>
                    <button type="submit" class="bg-[#2b1c50] text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
