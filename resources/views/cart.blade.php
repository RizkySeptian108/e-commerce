@extends('layouts.app')

@section('main-page')
    <div class="py-3 px-12">
        <h1 class="font-bold text-2xl uppercase">Cart</h1>
        <form action="{{ route('order.store') }}" method="post">
        <div class="grid grid-cols-12 mt-4 gap-2">
            @csrf
            <div class="col-span-9">
                <div class="bg-white p-4 rounded-t-xl">
                    <input type="checkbox" class="mr-2 rounded-md w-5 h-5" x-model="isChecked" id="check_all">
                    <span class="font-extrabold">Check all</span>
                </div>
            
                @php
                $previousKiosk = null;
                @endphp
            
                @foreach ($carts as $cart)
                    @if ($cart->product->kiosk->id !== $previousKiosk)
                        @if ($previousKiosk !== null)
                            </div>
                        @endif
                
                        <div class="bg-white p-4 mt-2">
                            <input type="checkbox" class="mr-2 rounded-md w-5 h-5" id="cart_kiosk_check">
                            <span class="font-extrabold">{{ $cart->product->kiosk->kiosk_name }}</span>
                    @endif
                
                    <div class="mt-2 border-b p-1" x-data="{isChecked: false}">
                        <div class="grid grid-cols-12 gap-2">
                            <input type="checkbox" name="product_id[]" class="mr-2 rounded-md w-5 h-5 col-span-1" value="{{ $cart->product->id }}" x-bind:checked="isChecked" x-on:change="isChecked = !isChecked" id="product_check">
                            <img src="{{ asset('storage/'. $cart->product->product_picture) }}" alt="" class="col-span-2 w-28">
                            <p class="col-span-6 text-ellipsis">{{ $cart->product->product_name }}</p>
                            <p class="col-span-3">{{ $cart->product->price_per_unit }}</p>
                        </div>
                        <div x-data="{qty: {{ $cart->qty }}, max: {{ $cart->product->qty }}}" class="mt-1 flex justify-end items-center gap-2">
                            <span class="inline-block">Stock: {{ $cart->product->qty }}</span>
                            <div class="flex gap-2 border rounded-xl border-slate-300 px-2 py-1 w-fit focus:outline-none">
                                <button type="button" x-on:click="qty <= 1 ? '' : qty-- " ><i class="fa-solid fa-minus"></i></button>
                                <input type="number" readonly  min="0" name="qty[]" x-model="qty" class="w-10 p-0 text-center border-none [&::-webkit-inner-spin-button]:appearance-none border-transparent focus:border-transparent focus:ring-0" id="" x-bind:disabled="!isChecked">
                                <button type="button" x-on:click="qty >= max ? '' : qty++" ><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                
                    @php
                        $previousKiosk = $cart->product->kiosk->id;
                    @endphp
                @endforeach
            
                
                @if (count($carts) > 0)
                    </div> <!-- Close the last container if there are items -->
                @endif
            </div>
            
            <div class="col-span-3">
                <div class="w-full bg-white p-4 rounded-lg">
                    <h3 class="font-bold text-lg text-center">Shopping summary</h3>
                    <div class="flex justify-between mt-2 items-center">
                        <span class="text-sm">Total :</span>
                        <span class="font-bold text-sm">Rp 1.000.000</span>
                    </div>
                    <x-primary-button class="mt-2 w-full">Buy</x-primary-button>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection