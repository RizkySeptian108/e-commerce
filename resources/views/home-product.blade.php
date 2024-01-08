@extends('layouts.app')

@section('main-page')
    <div class="bg-white rounded-md p-4">
        <x-title>{{ $page_title }} : {{ $product->product_name }}</x-title>

        <div class="grid grid-cols-10 mt-4">

            {{-- Picture section --}}
            <div class="col-span-3 p-1 " id="picture">
                <img src="{{ asset('storage/'. $product->product_picture) }}" class="w-full rounded-2xl" alt="">
            </div>

            {{-- Information Section --}}
            <div class="col-span-5 p-1  text-sm" >
                <div class="p-2 border shadow ">
                    <p class="text-3xl font-sans font-bold">{{ $product->product_name }}</p>
                    <h3 class="text-[#00AA5B] font-bold mt-2">Price</h3>
                    <p class="font-sans text-2xl">Rp. {{ number_format($product->price_per_unit) }}</p>
                    <h3 class="text-[#00AA5B] font-bold mt-2">Unit</h3>
                    <p class="text-lg">{{ $product->unit }}</p>
                    <h3 class="text-[#00AA5B] font-bold mt-2">Description</h3>
                    <p class="text-lg">{{ $product->description}}</p>
                </div>

                <hr class="mt-2">

                <div class="mt-2 shadow border p-2 ">
                    <div class="flex justify-between item-center">
                        <a href="{{ route('home', ['kiosk' => $product->kiosk_id]) }}" class="flex items-center">
                            <img src="{{ asset('storage/'. $product->kiosk->kiosk_logo) }}" alt="{{ $product->kiosk->kiosk_name }}" class="w-14 h-14 rounded-full border shadow object-cover mr-2">
                            <span class="font-extrabold text-xl">{{ $product->kiosk->kiosk_name }}</span>
                        </a>
                        <x-primary-button class="w-fit h-fit">follow</x-primary-button>
                    </div>
                    <div class="flex px-4 py-2">
                        <p class="mr-2"><i class="fa-solid fa-star mr"></i> 5.0 rata-rata ulasan</p> | <p class="ml-2"> 2000 pesanan</p>
                    </div>
                </div>
            </div>

            {{-- Quantity & price section --}}
            <div class="col-span-2 p-1">
                <div class="border border-green-700 rounded-md p-1">
                    <h1 class="font-extrabold text-lg text-center">Set quantity</h1>
                    <form action="" class="p-1">
                        <div class="flex gap-3 items-center">
                            <div class=" flex gap-2 border rounded-xl border-slate-300 px-2 py-1 w-fit focus:outline-none">
                                <button type="button"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" name="qty" value="0" class="w-10 p-0 text-center border-none [&::-webkit-inner-spin-button]:appearance-none border-transparent focus:border-transparent focus:ring-0" id="">
                                <button type="button"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <p><span class="font-semibold text-orange-400">Total stock</span>: {{ $product->qty }}</p>
                        </div>
                        <div class="flex m-2 justify-between items-center">
                            <p class="text-slate-400 text-sm">Total Price</p><p class="font-extrabold text-lg">Rp. 10,000,000</p>
                        </div>
                        <x-primary-button class="w-full"><i class="fa-solid fa-plus mr-1"></i> Cart</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection