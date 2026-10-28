
@props([
    'type' => 'success',
    'message' => null,
])

@php
    $colors = [
        'success' => 'background:#dcfce7;color:#166534;',
        'error' => 'background:#fee2e2;color:#991b1b;',
        'warning' => 'background:#fef3c7;color:#92400e;',
    ];

    $style = $colors[$type] ?? $colors['success'];
@endphp

<div role="alert"
     {{ $attributes->merge(['style' => $style . 'padding:12px 16px;margin-bottom:16px;border-radius:6px;']) }}>
    {{ $message ?? $slot }}
</div>
