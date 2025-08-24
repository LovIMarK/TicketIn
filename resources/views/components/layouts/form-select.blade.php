{{-- Select form component --}}
@props([
    'label' => '',
    'name',
    'id' => $name,
    'options' => [], // array of [id => name] OR collection
    'required' => false,
])

<div @class(['mb-4', 'relative rounded-md shadow-sm' => $errors->has($name)])>
    <label for="{{ $id }}" class="block text-sm font-medium mb-2 text-[#2b1c50]">
        {{ $label }}
    </label>

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        @class([
            'w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500',
            'ring-1 ring-red-500 placeholder:text-red-300 focus:ring-red-500' => $errors->has($name),
        ])
    >
        <option disabled selected>-- Select {{ strtolower($label) }} --</option>

        @foreach ($options as $key => $display)
            <option value="{{ is_object($display) ? $display->id : $key }}"
                {{ old($name) == (is_object($display) ? $display->id : $key) ? 'selected' : '' }}>
                {{ is_object($display) ? $display->name : $display }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
        </div>
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
