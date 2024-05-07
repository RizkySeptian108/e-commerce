@props(['active', 'link', 'page'])

@php
$classes = (Request::is(Str::lower(str_replace(' ', '-', $page)). '*'))
            ? 'mt-1 inline-flex items-center px-3 py-1 h-7 leading-5 hover:bg-slate-200 hover:rounded-md cursor-pointer w-full border-l-4 border-lime-400 rounded-l-md border-b-2 overflow-hidden'
            : 'mt-1 inline-flex items-center px-3 py-1 h-7 leading-5 hover:bg-slate-200 hover:rounded-md cursor-pointer w-full overflow-hidden';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} href="{{ $link }}">
    {{ $slot }} <span class="ml-2 transition-all delay-150 whitespace-nowrap" :class="{'md:opacity-0':!open}" >{{ $page }}</span>
</a>
