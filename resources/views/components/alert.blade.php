@props(['color'])

<div {{ $attributes->merge(['class' => "bg-$color-400  rounded-md justify-center p-4 font-semibold text-white mb-2 flex justify-between" ]) }} x-data="{open: true}" :class="open ? '' : 'hidden' ">
    {{ $slot }}
    <i class="fa-solid fa-x cursor-pointer"  @click="open = !open"></i>
</div>