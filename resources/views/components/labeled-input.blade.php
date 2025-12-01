@props([
    'inputId' => ''
])

<input
    {{ $attributes->merge(
        attributeDefaults: [
            'class' => 'peer w-full border-b-2 border-gray-300 bg-transparent py-2 focus:outline-none focus:border-orange-500'
        ])
    }}
/>

<label
    for="{{ $inputId }}"
    class="absolute left-0 top-2 text-gray-500 transition-all peer-focus:text-orange-500 peer-focus:-translate-y-5 peer-valid:text-orange-500 peer-valid:-translate-y-5"
>
    {{ $slot }}
</label>
