@php
    $level = session('flash.level');
    $message = session('flash.message');
    $styles = [
        'success' => 'bg-green-50 text-green-700 border-green-200',
        'error' => 'bg-[#fff2f2] text-[#f53003] border-red-200',
        'info' => 'bg-sky-50 text-sky-700 border-sky-200',
    ];
@endphp
@if($message)
    <div x-data="{ show: true }" x-show="show" class="mb-4 border rounded-sm px-4 py-3 {{ $styles[$level] ?? 'bg-[#FDFDFC] text-[#1b1b18] border-[#e3e3e0]' }}">
        <div class="flex items-start justify-between gap-4">
            <p>{{ $message }}</p>
            <button type="button" class="text-sm text-[#706f6c] hover:underline" @click="show=false">Dismiss</button>
        </div>
    </div>
@endif
