@extends('layouts.app')

@section('main-page')
    <x-title class="mb-4">
        {{ $page_title }}
    </x-title>
    <div class="bg-whit dark:bg-gray-500 rounded-md p-4 w-full">
        @if (session('success'))
            <x-alert color="green">{{ session('success') }}</x-alert>
        @endif
        
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-2">
            {{-- Search product --}}
            <form method="GET" action="{{ route('product.index') }}" class="relative">
                <x-text-input placeholder="search your product" class="w-full rounded-3xl" name="product_name" />
                <button type="submit" class="absolute right-3 bottom-2 dark:text-slate-300"><i class="fa-solid fa-magnifying-glass w-full"></i></button>
            </form>

            {{-- add button --}}
            <x-button-link href="{{ route('product.create') }}" class="bg-slate-800 text-center justify-center">add product</x-button-link>
        </div>

        <hr class="w-full mt-4">

        @if ($products->links())    
            <div class="mt-2">
                {{ $products->links() }}
            </div>
        @endif

        <div class="grid grid-cols-10 mt-2 gap-2 w-full">
            @foreach ($products as $product)    
            <div class="col-span-10 md:col-span-5 flex gap-2 w-full flex-col justify-between p-2 rounded-md border shadow dark:text-slate-200 dark:bg-gray-700">
                {{-- Product Picture --}}
                <div class="flex w-full gap-2">
                    <img src="{{ asset('storage/' . $product->product_picture) }}" alt="{{ $product->product_name }}" class="m-auto w-1/4">
                    <div class="flex gap-1 flex-col w-3/4">
                        <p class="text-green-600 dark:text-lime-300 font-bold text-lg">{{ $product->product_name }}</p>
                        <p class="text-xs font-bold">{{ $product->qty }}</p>
                        <p class="text-xs font-bold">Rp. {{ number_format($product->price_per_unit) }}</p>
                    </div>
                </div>
                {{-- Product Detail --}}
                <div class="w-full flex flex-row gap-1 justify-end">
                    <a href="{{ route('product.show', $product) }}" class="block mb-2 p-1 w-fit bg-green-600 rounded-md text-white mt"><i class="fa-solid fa-eye md:mr-1"></i><span class="ms-1 md:inline">detail</span></a>
                    <a href="{{ route('product.edit', $product) }}" class="block mb-2 p-1 w-fit bg-yellow-300 rounded-md text-white"><i class="fa-solid fa-pen-to-square md:mr-1"></i><span class="ms-1 md:inline">edit</span></a>
                    <form action="{{ route('product.destroy', $product) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="block p-1 bg-red-700 text-white rounded-md"><i class="fa-solid fa-trash-can md:mr-1"></i><span class="ms-1 md:inline">delete</span></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if ($products->links())    
            <div class="mt-2">
                {{ $products->links() }}
            </div>
        @endif

        
    </div> 
@endsection