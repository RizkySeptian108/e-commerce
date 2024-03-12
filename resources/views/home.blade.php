@extends('layouts.app')

@section('main-page')
    <div class="bg-white rounded-md md:mx-12 md:p-3 p-2">
        @if (!$searchs)  
            <x-slideshow />
        @endif

        <div class="mt-4 p-2 flex gap-2 w-full overflow-x-scroll border-b-2">
            @foreach ($categories as $category)
                <a class="bg-purple-700 md:p-3 p-2 rounded-full text-center font-bold font-sans text-white  w-fit bg-gradient-to-tr from-purple-400
                   @if(request('category') === $category->id) underline underline-offset-2 @endif"  
                   href="{{ route('home', ['category' => $category->id]) }}"
                   >
                   {{ $category->category_name }}
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

        <div class="flex gap-3 mt-2 flex-wrap justify-around">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class="w-40 md:w-44 p-2 border border-slate-200 shadow-md rounded-2xl ">
                        <div id="image-card" class="h-40 md:h-44 rounded-2xl overflow-hidden">
                            <a href="{{ route('home-product', $product) }}">
                                <img src="{{ asset('storage/'. $product->product_picture) }}" class="w-full h-full" alt="{{ $product->product_name }}">
                            </a>
                        </div>
                        <div id="body-card" class="p-1">
                            <a href="">
                                <h3 class="font-light text-sm">{{ $product->product_name }}</h3>
                            </a>
                            <h3 class="font-extrabold text-lg">Rp. {{ number_format($product->price_per_unit) }}</h3>
                            <a class="flex gap-1 items-center p-1 shadow border border-slate-200 rounded-md cursor-pointer mt-1" href="{{ route('home', ['kiosk' => $product->kiosk_id]) }}" >
                                <img 
                                    src="{{ asset('storage/'. $product->kiosk->kiosk_logo) }}" 
                                    alt="{{ $product->kiosk->kiosk_name }}"
                                    class="w-5 h-5 rounded-full shadow border"
                                    >
                                <p class="">{{ $product->kiosk->kiosk_name }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="opacity-40 font-bold">no results found!</p>
            @endif
        </div>
        <div class="mt-2">
            {{ $products->links() }}
        </div>

    </div>
    
@endsection