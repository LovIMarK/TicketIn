<x-layouts.user>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-[#2b1c50] mb-6">Create a New Ticket</h1>

        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-2b1c50 rounded-xl shadow p-6 space-y-6">
            @csrf

            <!-- Title -->
            <x-layouts.form-input id="title" value="" name="title" label="Title" type="text" placeholder="Enter the subject of your issue required" />


            <!-- Initial Message -->
            <x-layouts.form-area id="content"  value=""  name="content" label="Message" placeholder="Describe your issue or request..." rows="5" required />


            <!-- Attachment -->
            <div>
                <label class="block text-sm font-medium text-[#2b1c50] mb-1">Attachment</label>
                <input
                    type="file"
                    name="attachment"
                    value="{{ old('attachment') }}"
                    class="block w-full rounded border border-[#2b1c50] px-4 py-2 text-sm text-[#2b1c50]
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0 file:text-sm file:font-semibold
                            file:bg-[#2b1c50] file:text-white hover:file:bg-indigo-700
                            transition duration-150 ease-in-out">
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button type="submit"
                    class="bg-[#2b1c50] text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Submit Ticket
                </button>
            </div>
        </form>
    </div>
</x-layouts.user>
