@props(['label' => null, 'error' => null, 'name' => null, 'type' => 'text'])
<label class="block text-sm font-medium text-[#3a3a33]">
    @if($label)
        <span class="block mb-1">{{ $label }}</span>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full rounded-md border border-[#d9d9d4] bg-white px-5 py-2 text-base leading-6 shadow-sm transition focus:border-[#9b9b93] focus:outline-none focus:ring-2 focus:ring-[#1b1b18]/10']) }}
    >
    @if($error)
        <p class="mt-1 text-sm text-[#f53003]">{{ $error }}</p>
    @endif
</label>
