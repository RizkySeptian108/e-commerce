@extends('layouts.app')

@section('main-page')
    <x-title class="mb-4">
        {{ $page_title }}
    </x-title>
    <div class="bg-white rounded-md p-4">
        @if (session('success'))
            <x-alert color="green">{{ session('success') }}</x-alert>
        @endif
        
        <div class="flex flex-row justify-between items-center">
            {{-- Search product --}}
            <form method="GET" action="{{ route('product.index') }}" class="relative">
                <x-text-input placeholder="search your product" class="w-full rounded-3xl" name="product_name" />
                <button type="submit" class="absolute right-3 bottom-2"><i class="fa-solid fa-magnifying-glass w-full"></i></button>
            </form>

            {{-- add button --}}
            <x-button-link href="{{ route('product.create') }}" class="bg-slate-800">add product</x-button-link>
        </div>
        <table class="w-full mt-4">
            @if ($products->links())    
                <div class="mt-2">
                    {{ $products->links() }}
                </div>
            @endif
            <thead>
                <tr class="border-y border-slate-300 font-semibold text-slate-700 ">
                    <th class="py-2">No</th>
                    <th class="py-2">Picture</th>
                    <th class="py-2">Product Name</th>
                    <th class="py-2">Quantity</th>
                    <th class="py-2">Price</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-y border-slate-300 text-center">
                        <td class="border-e border-slate-300">{{ $loop->iteration }}</td>
                        <td class="border border-slate-300 p-2">
                            <img src="{{ asset('storage/' . $product->product_picture) }}" alt="{{ $product->product_name }}" class="m-auto w-[200px]">
                        </td>
                        <td class="border border-slate-300">{{ $product->product_name }}</td>
                        <td class="border border-slate-300">{{ $product->qty }}</td>
                        <td class="border border-slate-300">Rp. {{ number_format($product->price_per_unit) }}</td>
                        <td class="border-s border-slate-300">
                            <a href="{{ route('product.show', $product) }}" class="block mx-auto mb-2 p-1 w-fit bg-green-600 rounded-md text-white mt"><i class="fa-solid fa-eye md:mr-1"></i><span class="hidden md:inline">detail</span></a>
                            <a href="{{ route('product.edit', $product) }}" class="block mx-auto mb-2 p-1 w-fit bg-yellow-300 rounded-md text-white"><i class="fa-solid fa-pen-to-square md:mr-1"></i><span class="hidden md:inline">edit</span></a>
                            <form action="{{ route('product.destroy', $product) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button class="block mx-auto p-1 bg-red-700 text-white rounded-md"><i class="fa-solid fa-trash-can md:mr-1"></i><span class="hidden md:inline">delete</span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($products->links())    
            <div class="mt-2">
                {{ $products->links() }}
            </div>
        @endif
    </div> 
@endsection