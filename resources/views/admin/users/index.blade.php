<x-layouts.admin>
    <main class="max-w-6xl mx-auto py-10 px-6">
        <h1 class="text-2xl font-bold text-[#2b1c50] mb-6">User Management</h1>

        <a href="{{ route('admin.users.create') }}" class="mb-4 inline-block bg-[#2b1c50] text-white px-4 py-2 rounded hover:bg-indigo-700">
            Add New User
        </a>
        <div class="bg-white p-6 rounded-lg shadow-md border">

        @foreach ($departments as $department)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-[#2b1c50] mb-3">{{ $department->name }}</h2>
                @if ($department->users->isEmpty())
                    <p class="text-gray-500 italic">No users in this department.</p>
                @else
                    <div class="overflow-x-auto bg-white shadow rounded-lg">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-200 border-b">
                                <tr>
                                    <th class="p-4">Name</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Role</th>
                                    <th class="p-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department->users as $user)
                                    <tr class="border-b">
                                        <td class="p-4">{{ $user->name }}</td>
                                        <td class="p-4">{{ $user->email }}</td>
                                        <td class="p-4 capitalize">{{ $user->role }}</td>
                                        <td class="p-4 flex gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach
    </main>
</x-layouts.admin>
