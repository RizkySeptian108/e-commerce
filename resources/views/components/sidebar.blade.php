<nav {{ $attributes->merge(['class' => 'sticky top-[65px] w-1/2 md:w-1/6 bg-white text-gray-800 p-3 h-screen duration-200 z-50']) }} x-data="{open: true}" :class="open ? '' : 'md:w-12 py-3 px-1 hidden md:block' ">
    <div class="px-3 py-1 text-center hover:bg-slate-200 hover:rounded-md cursor-pointer " @click="open = !open" >
        <i class="fa-solid fa-angle-left mr-1 duration-200 " :class="open ? '' : 'rotate-180'"></i><span class="font-bold " :class="open ? '' : 'hidden' ">close</span>
    </div>
    <hr class="mt-2">

    <x-nav-link page="Dashboard" link="{{ route('dashboard') }}">
        <i class="fa-solid fa-house"></i>
    </x-nav-link>

    @if (Auth::user()->access_id === 1)    
        {{-- Admin exclusive menu --}}
        <hr class="mt-2">
        {{-- Category link --}}
        <x-nav-link page="Category" link="{{ route('category.index') }}">
            <i class="fa-solid fa-puzzle-piece"></i>
        </x-nav-link>
        {{-- Payment method --}}
        <x-nav-link page="Payment Method" link="{{ route('payment-method.index') }}">
            <i class="fa-regular fa-credit-card"></i>
        </x-nav-link>
        {{-- Shipment method --}}
        <x-nav-link page="Shipment Method" link="{{ route('shipment-method.index') }}">
            <i class="fa-solid fa-truck"></i>
        </x-nav-link>
        {{-- Access --}}
        <x-nav-link page="Access" link="{{ route('access.index') }}">
            <i class="fa-solid fa-lock"></i>
        </x-nav-link>
    @endif

</nav>