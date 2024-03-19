@extends('layouts.app')

@section('main-page')
    <div class="bg-white rounded-md p-4">
        <x-title>{{ $page_title }} : {{ $product->product_name }}</x-title>

        <div class="md:grid grid-cols-6 mt-4">

            {{-- Picture section --}}
            <div class="col-span-2 p-1" id="picture">
                <img src="{{ asset('storage/'. $product->product_picture) }}" class="w-full" alt="">
            </div>

            {{-- Information Section --}}
            <div class="col-span-3 p-2  text-sm" >
                <h3 class="text-[#00AA5B] font-bold">Product Name</h3>
                <p class="text-lg">{{ $product->product_name }}</p>
                <h3 class="text-[#00AA5B] font-bold">Category</h3>
                <p class="text-lg">{{ $product->category->category_name }}</p>
                <h3 class="text-[#00AA5B] font-bold">Quantity</h3>
                <p class="text-lg">{{ $product->qty }}</p>
                <h3 class="text-[#00AA5B] font-bold">Unit</h3>
                <p class="text-lg">{{ $product->unit }}</p>
                <h3 class="text-[#00AA5B] font-bold">Description</h3>
                <p class="text-lg">{{ $product->description}}</p>
            </div>

            {{-- Quantity & price section --}}
            <div class="col-span-1 ">
                <div class="border border-green-700 rounded-md p-1 text-center">
                    <h2 class="font-bold text-white bg-[#00AA5B] rounded-md">Quantity</h2>
                    <span class="text-6xl">{{ $product->qty }}</span>
                    <h2 class="font-bold text-white bg-[#00AA5B] rounded-md">Price</h2>
                    <span class="text-2xl">Rp. {{ number_format($product->price_per_unit) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection