@extends('layouts.app')

@section('main-page')
    <x-title>
        {{ $page_title }}
    </x-title>
    
    <div class="max-w-7xl mx-auto mt-4">
        @if (session('success'))
            <x-alert color="green">{{ session('success') }}</x-alert>
        @endif
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 md:p-6 grid grid-cols-2 md:grid-cols-4 gap-2 w-full">
                <a href="{{ route('product.index') }}" class="col-span-1 bg-red-600 rounded-md p-1 md:p-3 text-white text-center align-middle justify-center">
                    <p class="text-8xl font-extrabold">{{ $products }}</p>
                    <i class="fa-solid fa-box text-5xl"></i>
                    <p class="text-3xl font-extrabold uppercase">Products</p>
                </a>
                <a href="{{ route('order.index') }}" class="col-span-1 bg-blue-600 rounded-md p-1 md:p-3 text-white text-center align-middle justify-center" x-data="{orders: ''}" x-init="orders = fetch(`{{ route('order.kiosk', ['kiosk_id' => Auth::user()->kiosk->id ]) }}`).then(response => response.json()).then(data => data.orders).then(ordersData => orders = ordersData)">
                    <p x-text="orders" class="text-8xl font-extrabold"></p>
                    <i class="fa-solid fa-list-check text-5xl"></i>
                    <p class="text-3xl font-extrabold uppercase">Orders</p>
                </a>
                <div class="col-span-1 bg-green-600 rounded-md p-1 md:p-3 text-white text-center align-middle justify-center" x-data="{orders: ''}" x-init="orders = fetch(`{{ route('order.kiosk', ['is_confirm' => 1 ]) }}`).then(response => response.json()).then(data => data.orders).then(ordersData => orders = ordersData)">
                    <p x-text="orders" class="text-8xl font-extrabold"></p>
                    <i class="fa-solid fa-truck-fast text-5xl"></i>
                    <p class="text-3xl font-extrabold uppercase">On Delivery</p>
                </div>
                <div class="col-span-1 bg-yellow-400 rounded-md p-1 md:p-3 text-white text-center align-middle justify-center" x-data="{carts: ''}" x-init="carts = fetch(`{{ route('cart.count', ['kiosk_id' => Auth::user()->kiosk->id ]) }}`).then(response => response.json()).then(data => data.carts).then(cartsData => carts = cartsData)">
                    <p x-text="carts" class="text-8xl font-extrabold"></p>
                    <i class="fa-solid fa-cart-shopping text-5xl"></i>
                    <p class="text-3xl font-extrabold uppercase">On Carts</p>
                </div>
            </div>
        </div>
    </div>

@endsection