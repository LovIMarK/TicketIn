<x-layouts.user>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-[#2b1c50] mb-6">My Profile</h1>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="bg-white border border-2b1c50 rounded-xl shadow p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 p-2 w-full border rounded">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 p-2 w-full border rounded">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="mt-1 p-2 w-full border rounded">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-[#2b1c50] text-white px-4 py-2 rounded hover:bg-indigo-700">
                Save Changes
            </button>
        </form>
    </div>
</x-layouts.user>
