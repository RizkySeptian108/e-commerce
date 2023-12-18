

<nav {{ $attributes->merge(['class' => 'sticky left-0 top-[65px] w-1/2 md:w-1/6 bg-white text-gray-800 p-3 h-screen duration-200']) }} x-data="{open: true}" :class="open ? '' : 'md:w-12 py-3 px-1 hidden md:block' ">
    <div class="px-3 py-1 text-center hover:bg-slate-200 hover:rounded-md cursor-pointer" @click="open = !open" >
        <i class="fa-solid fa-angle-left mr-1 duration-200 " :class="open ? '' : 'rotate-180'"></i><span class="font-bold " :class="open ? '' : 'hidden' ">close</span>
    </div>
    <hr class="mt-2">

    <x-nav-link page="Dashboard" link="{{ route('dashboard') }}">
        <i class="fa-solid fa-house"></i>
    </x-nav-link>

    {{-- Admin exclusive menu --}}
    <h2 class="mt-2 text-center font-semibold border-b-2 border-slate-200 block">Admin</h2>
    <x-nav-link page="Category" link="{{ route('category') }}">
        <i class="fa-solid fa-puzzle-piece"></i>
    </x-nav-link>



</nav>