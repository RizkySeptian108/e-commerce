@props(['color'])

@php
    $colorClassess = $color
    ? 'bg-' . $color . '-400'
    : 'bg-green-400'
@endphp

<div class="{{ $colorClassess }} rounded-md p-4 font-semibold text-white mb-2 flex justify-between" x-data="{open: true}" :class="open ? '' : 'hidden' ">
    {{ $slot }}
    <i class="fa-solid fa-x cursor-pointer"  @click="open = !open"></i>
</div>