@props([
    'heading' => '',
    'variant' => 'success'
])


@if ($variant === "success")
    <div class="flex items-center space-x-3 mb-4">
        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
            <i class="fas fa-circle-check text-green-800"></i>
        </div>
        <h2 class="text-lg font-semibold">{{ $heading }}</h2>
    </div>
@endif

@if ($variant === 'retry')
    <div class="flex items-center space-x-3 mb-4">
        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
            <i class="fas fa-sync-alt text-yellow-600"></i>
        </div>
        <h2 class="text-lg font-semibold">{{ $heading }}</h2>
    </div>
@endif


{{ $slot }}
