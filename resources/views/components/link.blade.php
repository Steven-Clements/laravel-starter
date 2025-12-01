@props([
    'type' => 'main-menu',
    'active' => false
])


@if ($type === 'main-menu')
    <a {{ $attributes->merge([
        'class' => $active ?
            'block rounded-md px-3 py-2 text-base font-medium bg-gray-700 text-white' :
            'block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white'
        ])
    }}>
        {{ $slot }}
    </a>
@endif


@if ($type === 'sub-menu')
    <a {{ $attributes->merge([
        'class' => $active ?
            'block rounded-md px-3 py-2 text-base font-medium bg-gray-200 text-gray-800 hover:bg-gray-300' :
            'block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-300 hover:text-gray-800'
        ])
    }}>
        {{ $slot }}
    </a>
@endif

@if ($type === 'footer-menu')
    <a {{ $attributes->merge([
        'class' => $active ?
            'block rounded-md px-2 py-1 text-sm bg-gray-700 text-white' :
            'block rounded-md px-2 py-1 text-sm text-gray-300 hover:bg-white/5 hover:text-white'
        ]) 
    }}>
        {{ $slot }}
    </a>
@endif
