@props([
  'as' => 'button',
  'variant' => 'primary', // primary|outline|ghost
])
@php
  $classes = [
    'inline-flex items-center justify-center rounded-sm text-sm px-4 py-2 transition-colors',
    match($variant){
      'outline' => 'border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] bg-white',
      'ghost' => 'text-[#1b1b18] hover:bg-black/5',
      default => 'bg-[#1b1b18] text-white border border-black hover:bg-black',
    }
  ];
@endphp
@if($as === 'a')
  <a {{ $attributes->merge(['class' => implode(' ', $classes)]) }}>
    {{ $slot }}
  </a>
@else
  <button {{ $attributes->merge(['class' => implode(' ', $classes)]) }}>
    {{ $slot }}
  </button>
@endif
