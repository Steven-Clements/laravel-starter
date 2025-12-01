{{-- Component properties --}}
@props([
    'variant' => 'primary',
    'isLink' => false
])

{{-- Button-styled links --}}
@if ($isLink === true)
    {{-- Primary button --}}
    @if ($variant === 'primary')
        <a
            {{ $attributes->merge(['class' => 'mt-6 w-full py-2 rounded-md border bg-orange-400 text-white hover:bg-orange-500 cursor-pointer transition-transform']) }}
        >
            {{ $slot }}
        </a>
    {{-- Alternate button --}}
    @elseif ($variant === 'alternate')
        <a
            {{ $attributes->merge(['class' => 'mt-2 w-full block text-center py-2 rounded-md border bg-orange-200 text-gray-700 cursor-pointer hover:bg-orange-300 transition-transform']) }}
        >
            {{ $slot }}
        </a>
    @endif


{{-- Standard buttons --}}
@else
    {{-- Primary button --}}
    @if ($variant === 'primary')
        <button
            {{ $attributes->merge(['class' => 'mt-6 w-full py-2 rounded-md border bg-orange-400 text-white hover:bg-orange-500 transition-transform']) }}
        >
            {{ $slot }}
        </button>
    

    {{-- Alternate button --}}
    @elseif ($variant === 'alternate')
        <button
            {{ $attributes->merge(['class' => 'mt-2 w-full py-2 rounded-md border bg-orange-200 text-gray-700 hover:bg-orange-300 transition-transform']) }}
        >
            {{ $slot }}
        </button>
    @endif
@endif
