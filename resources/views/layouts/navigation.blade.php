<nav x-data="{ open: false , search: false}" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky z-10 top-0 shadow grid grid-cols-12 py-3 px-3 md:px-16 items-center gap-3" >
    <!-- Primary Navigation Menu -->
    <div class="col-span-1 lg:col-span-3 md:col-span-2">
        <!-- Logo -->
        <div class="shrink-0 w-full flex">
            <a href="/" class="text-lg text-slate-600 md:hidden">
                <i class="fa-solid fa-house block w-full"></i>
            </a>
            <a href="{{ route('home') }}" class="hidden md:block">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>
    </div>

    {{-- search input bar --}}
    <div class="flex flex-row md:block items-center gap-2 md:col-span-7 lg:col-span-6 transition-all" :class="{ 'col-span-11': search, 'col-span-7': !search }" x-cloak>
        <form method="GET" action="{{ route('home') }}" class="relative flex-grow" >
            @csrf
            
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            @if (request('kiosk'))
                <input type="hidden" name="kiosk" value="{{ request('kiosk') }}">
            @endif

            <x-text-input name="search" placeholder="insert item name" @click="search = !search" class="w-full rounded-lg" />
            <button type="submit" class="absolute right-3 bottom-2"><i class="fa-solid fa-magnifying-glass w-full"></i></button>
        </form>
    </div>

    {{-- Account informastion --}}
    <div class="col-span-4 md:col-span-3 md:block flex justify-end" :class="{ 'hidden': search }">
        @if (Auth::user())           
            <!-- Settings Dropdown -->
            <div class="flex flex-row items-center justify-end">
                
                {{-- ordersdropdown --}}
                <div x-data="{ orders: []}" x-init="orders = fetch(`{{ route('order.list', ['user_id' => Auth::user()->id ]) }}`).then(response => response.json()).then(data => data.orders).then(ordersData => orders = ordersData)" >
                    <x-dropdown width="w-80" dropdownClass="max-sm:-right-16">
                        <x-slot name="trigger">
                            <button class="text-slate-600 relative mr-4">
                                <i class="fa-solid fa-box-open"></i>
                                <p class="bg-red-600 text-sm text-white rounded-md text-[12px] absolute w-fit px-1 -bottom-2 left-3" x-show="orders.length > 0" x-text="orders.length"></p>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="overflow-y-auto max-h-72">
                                <template x-for="order in orders">
                                    <div class="p-2 flex gap-2 items-center justify-between">
                                        <img :src="`{{ asset('storage/') }}/${order.product.product_picture}`" alt="" class="w-14 h-14">
                                        <div class="flex-grow text-left">
                                            <p x-text="order.product.product_name" class="font-bold uppercase"></p>
                                            <p class="text-sm"><span x-text="order.qty" class="mr-1"></span><span x-text="order.product.unit"></span></p>
                                        </div>
                                        <p x-text="order.status" class="text-right text-sm font-semibold text-orange-400"></p>
                                    </div>
                                </template>
                                <div x-show="orders.length <= 0" class="p-2 text-center">
                                    <span class="font-bold text-orange-400">You haven't order anything yet!</span>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                
                {{-- cartdropdown --}}
                <div x-data="{ carts: []}" x-init="carts = fetch(`{{ route('cart.shows', ['user_id' => Auth::user()->id ]) }}`).then(response => response.json()).then(data => data.carts).then(cartsData => carts = cartsData)">
                    <x-dropdown align="rigth" width="w-80" dropdownClass="max-sm:-right-8">
                        <x-slot name="trigger">
                            <button class="text-slate-600 relative mr-4">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <p class="bg-red-600 text-sm text-white rounded-md text-[12px] absolute w-fit px-1 -bottom-2 left-3" x-show="carts.length > 0" x-text="carts.length"></p>
                            </button>
                        </x-slot>
                        <x-slot name="content" >
                            <div class="overflow-y-auto max-h-72">
                                <template x-for="cart in carts">
                                    <div class="p-2 flex gap-2 items-center justify-between">
                                        <img :src="`{{ asset('storage/') }}/${cart.product.product_picture}`" alt="" class="w-14 h-14">
                                        <div class="flex-grow text-left">
                                            <p x-text="cart.product.product_name" class="font-bold uppercase"></p>
                                            <p class="text-sm"><span x-text="cart.qty" class="mr-1"></span><span x-text="cart.product.unit"></span></p>
                                        </div>
                                        <p x-text="(cart.qty * cart.product.price_per_unit).toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0}) " class="text-right text-sm font-semibold text-lime-500"></p>
                                    </div>
                                </template>
                                <div x-show="carts.length > 0" class="w-full px-2 flex justify-end mb-2">
                                    <form action="{{ route('cart.index') }}" method="GET">
                                        <x-primary-button>Cart</x-primary-button>
                                    </form>
                                </div>
                                <div>
                                    <div x-show="carts.length <= 0" class="p-2 text-center">
                                        <span class="font-bold text-orange-400">Your cart is empty!</span>
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Account dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="md:inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 hidden">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if (isset(Auth::user()->kiosk))
                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Your Kiosk') }}
                            </x-dropdown-link>
                        @else
                        <x-dropdown-link :href="route('kiosk.create')">
                            {{ __('Create Kiosk') }}
                        </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            @method('POST')
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

            </div>
        @else
            <div class="md:flex justify-end gap-2 hidden">
                <a href="{{ route('login') }}" class="inline-flex items-center px-2 py-1 md:px-4 md:py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest  transition ease-in-out duration-150">Login</a>
                <a href="{{ route('register') }}" class="inline-flex items-center px-2 py-1 md:px-4 md:py-2 border border-slate-800 rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">Register</a>
            </div>
        @endif
    
    <!-- Hamburger -->
    <div class="flex justify-end md:hidden items-center">
        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>    
        
    </div>
    <!-- Responsive Navigation Menu -->
    <div x-show="open" x-cloak class="transition-all duration-200 flex" x-transition>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @if (Auth::user())    
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Auth::user()->kiosk)    
                    {{-- Kiosk control link --}}
                    <x-responsive-nav-link :href="route('dashboard')">
                        {{ __('Your Kiosk') }}
                    </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endif

        </div>
    </div>
</nav>

