@props(['type' => 'success'])

<div {{ $attributes->class([
    'p-3 rounded',
    'bg-green-100 text-green-800' => $type === 'success',
    'bg-red-100 text-red-800' => $type === 'error',
]) }}>
    {{ $slot }}
</div>
