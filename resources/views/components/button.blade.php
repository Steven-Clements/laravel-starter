@props([
    'variant' => 'primary',
    'isLink' => false
])

@if ($isLink === true)
    @if ($variant === 'primary')
        <a
            {{ $attributes->merge(['class' => 'mt-6 w-full py-2 rounded-md border bg-orange-400 text-white hover:bg-orange-500 cursor-pointer transition-transform']) }}
        >
            {{ $slot }}
        </a>
    @elseif ($variant === 'alternate')
        <a
            {{ $attributes->merge(['class' => 'mt-2 w-full block text-center py-2 rounded-md border bg-orange-200 text-gray-700 cursor-pointer hover:bg-orange-300 transition-transform']) }}
        >
            {{ $slot }}
        </a>
    @endif

@else
    @if ($variant === 'primary')
        <button
            {{ $attributes->merge(['class' => 'mt-6 w-full py-2 rounded-md border bg-orange-400 text-white hover:bg-orange-500 transition-transform']) }}
        >
            {{ $slot }}
        </button>
        
    @elseif ($variant === 'alternate')
        <button
            {{ $attributes->merge(['class' => 'mt-2 w-full py-2 rounded-md border bg-orange-200 text-gray-700 hover:bg-orange-300 transition-transform']) }}
        >
            {{ $slot }}
        </button>
    @endif
@endif
