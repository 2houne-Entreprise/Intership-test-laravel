@props(['type' => 'success'])

@php
    $colors = match ($type) {
        'error' => 'bg-red-50 border-red-200 text-red-800',
        default => 'bg-green-50 border-green-200 text-green-800',
    };
@endphp

<div role="alert" {{ $attributes->merge(['class' => "p-4 border rounded-md {$colors}"]) }}>
    {{ $slot }}
</div>
