@props([
    'folderName' => '',
    'filesAmount' => 0,
    'isActive' => false,
])

@php
    $classes =
        'border-1 border-frost/50 rounded-md flex items-center p-2 gap-2 hover:bg-frost/5 transition-all cursor-pointer';
    $classes .= $isActive ? ' border-primary text-background-foreground bg-primary hover:bg-primary/90' : ' text-frost';

    $icon = $isActive ? 'icon-folder-open' : 'icon-folder';
@endphp

<div
    {{ $attributes->merge([
        'class' => $classes . ' folder-select',
        'data-pathfolder' => $folderName,
    ]) }}>
    <i class="{{ $icon }}"></i>
    <span class="grow truncate">{{ $folderName }}</span>
    <span>{{ $filesAmount }}</span>
</div>
