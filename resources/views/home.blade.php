@extends('layouts.app')

@section('main-page')
    <div class="bg-white rounded-md md:mx-12 md:p-3 p-2 dark:bg-gray-500">
        @if (!$searchs)  
            <x-slideshow />
        @endif

        <div class="mt-4 p-2 flex gap-2 w-full overflow-x-scroll border-b-2">
            @foreach ($categories as $category)
                <a class="whitespace-nowrap bg-purple-700 dark:bg-gray-800 md:p-3 p-2 rounded-full text-center font-bold font-sans text-white w-fit bg-gradient-to-tr from-purple-400
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

        <div class="md:flex gap-2 mt-2 flex-wrap grid grid-cols-2 justify-around">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class=" w-auto md:w-44 border border-slate-200 shadow-md rounded-xl mb-1 md:mb-2 ">
                        <div id="image-card" class="h-40 md:h-44 rounded-t-xl overflow-hidden">
                            <a href="{{ route('home-product', $product) }}">
                                <img src="{{ asset('storage/'. $product->product_picture) }}" class="w-full h-full" alt="{{ $product->product_name }}">
                            </a>
                        </div>
                        <div id="body-card " class="p-1">
                            <a class="" href="{{ route('home-product', $product) }}">
                                <h3 class="font-light text-sm dark:text-lime-300 p-1 rounded-md dark:hover:bg-gray-900" dark:hover:border-l-lime-400 >{{ $product->product_name }}</h3>
                            </a>
                            <h3 class="font-extrabold text-lg dark:text-slate-200">Rp. {{ number_format($product->price_per_unit) }}</h3>
                            <a class="flex dark:text-slate-300 gap-1 items-center p-1 shadow border border-slate-200 rounded-md cursor-pointer mt-1 dark:hover:bg-slate-200 dark:hover:text-slate-800" href="{{ route('home', ['kiosk' => $product->kiosk_id]) }}" >
                                <img 
                                    src="{{ asset('storage/'. $product->kiosk->kiosk_logo) }}" 
                                    alt="{{ $product->kiosk->kiosk_name }}"
                                    class="w-5 h-5 rounded-full shadow border"
                                    >
                                <p class=" ">{{ $product->kiosk->kiosk_name }}</p>
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