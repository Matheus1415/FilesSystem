@props([
    'icon' => '',
    'variant' => 'secondary'
])

@php
    $isPrimary = $variant === 'primary';

    $classes = 'flex items-center justify-center w-full border-2 rounded-md py-1 px-2 gap-2 capitalize transition-all cursor-pointer';
    $classes .= $isPrimary 
        ? ' bg-primary border-primary text-background-foreground hover:bg-primary/90'
        : ' border-primary text-primary hover:bg-primary/5';
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif
    <span class='grow text-center'>
        {{ $slot }}
    </span>
</button>