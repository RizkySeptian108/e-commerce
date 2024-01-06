@extends('layouts.app')

@section('main-page')
    <div class="bg-white rounded-md md:mx-12 p-3">
        <x-slideshow />

        <div class="mt-4">
            {{ $products->links() }}
        </div>
        <div class="flex gap-3 mt-2 flex-wrap justify-around">
            @foreach ($products as $product)
                <div class="w-44 p-2 border border-slate-200 shadow-md rounded-2xl ">
                    <div id="image-card" class="h-44 rounded-2xl overflow-hidden">
                        <a href="">
                            <img src="{{ asset('storage/'. $product->product_picture) }}" class="w-full h-full" alt="{{ $product->product_name }}">
                        </a>
                    </div>
                    <div id="body-card" class="p-1">
                        <a href="">
                            <h3 class="font-light text-sm">{{ $product->product_name }}</h3>
                        </a>
                        <h3 class="font-extrabold text-lg">Rp. {{ number_format($product->price_per_unit) }}</h3>
                        <a class="flex gap-1 items-center p-1 shadow border border-slate-200 rounded-md cursor-pointer mt-1" >
                            <img 
                                src="{{ asset('storage/'. $product->kiosk->kiosk_logo) }}" 
                                alt="{{ $product->kiosk->kiosk_name }}"
                                class="w-5 h-5 rounded-full shadow border"
                                >
                            <p href="" class="">{{ $product->kiosk->kiosk_name }}</p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $products->links() }}
        </div>

    </div>
    
@endsection