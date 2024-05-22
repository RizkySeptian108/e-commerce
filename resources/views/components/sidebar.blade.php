<nav {{ $attributes->merge(['class' => 'sticky max-sm:fixed md:py-3 md:px-1 top-[65px] h-screen md:w-1/6 bg-white text-gray-800 dark:bg-gray-600 dark:text-slate-200 duration-200 z-30 relative ']) }} x-data="{open: true}" :class="open ? 'w-0' : 'w-48 md:w-12 md:block'">
    <div class="bg-slate-900 dark:bg- md:hidden text-white opacity-50 fixed rounded-full bottom-4 left-2 p-2 hover:cursor-pointer" @click="open = !open" id="tombol">
        <i class="fa-solid fa-arrow-right"></i>
    </div>

    <div :class="{'max-sm:hidden':open}">
        <div class="flex justify-center h-6 items-center px-3 py-1 hover:bg-slate-200 dark:hover:text-slate-800 hover:rounded-md cursor-pointer z-50" @click="open = !open" >
            <i class="fa-solid fa-angle-left mr-1 duration-200 " :class="open ? '' : 'md:rotate-180'"></i><span class="font-bold" :class="{'md:hidden':!open}" x-transition:enter.duration.500ms>close</span>
        </div>
        <hr class="mt-2">
    
        @if (Auth::user()->kiosk)    
            {{-- Kiosk Menu --}}
            <x-nav-link page="Dashboard" link="{{ route('dashboard') }}">
                <i class="fa-solid fa-house"></i>
            </x-nav-link>
            <x-nav-link page="Product" link="{{ route('product.index') }}">
                <i class="fa-solid fa-box"></i>
            </x-nav-link>
            <x-nav-link page="Order" link="{{ route('order.index') }}">
                <i class="fa-solid fa-list-check"></i>
            </x-nav-link>

        @endif
    
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
    </div>
    


</nav>