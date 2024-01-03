@props(['active', 'link', 'page'])

@php
$classes = (Request::is(Str::lower($page). '*'))
            ? 'mt-1 inline-flex items-center px-3 py-1 leading-5 hover:bg-slate-200 hover:rounded-md cursor-pointer w-full border-l-4 border-lime-400 rounded-l-md border-b-2'
            : 'mt-1 inline-flex items-center px-3 py-1 leading-5 hover:bg-slate-200 hover:rounded-md cursor-pointer w-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} href="{{ $link }}" :class="open ? '' : 'border-b-0'">
    {{ $slot }} <span class="ml-2" :class="open ? '' : 'hidden' ">{{ $page }}</span>
</a>
