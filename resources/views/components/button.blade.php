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
            {{ $attributes->merge(['class' => 'mt-4 w-full py-2 block text-center rounded-md border bg-orange-500 text-white hover:bg-orange-600 cursor-pointer transition-transform']) }}
        >
            {{ $slot }}
        </a>


    {{-- Success button --}}
    @elseif ($variant === 'success')
        <a
            {{ $attributes->merge(['class' => 'mt-4 w-full block text-center py-2 rounded-md border bg-green-500 text-white cursor-pointer hover:bg-green-600 transition-transform']) }}
        >
            {{ $slot }}
        </a>


    {{-- Info button --}}
    @elseif ($variant === 'info')
        <a
            {{ $attributes->merge(['class' => 'mt-4 w-full block text-center py-2 rounded-md border bg-blue-500 text-white cursor-pointer hover:bg-blue-600 transition-transform']) }}
        >
            {{ $slot }}
        </a>
    @endif


{{-- Standard buttons --}}
@else
    {{-- Primary button --}}
    @if ($variant === 'primary')
        <button
            {{ $attributes->merge(['class' => 'mt-4 w-full py-2 rounded-md border bg-orange-500 text-white hover:bg-orange-600 transition-transform']) }}
        >
            {{ $slot }}
        </button>
    

    {{-- Success button --}}
    @elseif ($variant === 'success')
        <button
            {{ $attributes->merge(['class' => 'mt-4 w-full py-2 rounded-md border bg-green-500 text-white hover:bg-green-600 transition-transform']) }}
        >
            {{ $slot }}
        </button>

    
    {{-- Info button --}}
    @elseif ($variant === 'info')
        <button
            {{ $attributes->merge(['class' => 'mt-6 w-full py-2 rounded-md border bg-blue-500 text-white hover:bg-blue-600 transition-transform']) }}
        >
            {{ $slot }}
        </button>
    @endif
@endif
