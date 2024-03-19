@extends('layouts.app')

@section('main-page')
    <x-title class="mb-4">{{ $page_title }}</x-title>
    <div class="p-4 bg-white rounded-md">
        <form action="{{ route('product.store') }}" method="post" class="md:w-1/2" enctype="multipart/form-data">
            @csrf
            <div>
                <x-input-label for="product_name" :value="__('Product Name')" />
                <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block w-full" :value="old('product_name')" required />
                <x-input-error class="mt-2" :messages="$errors->get('product_name')" />
            </div>
            <div class="mt-4">
                <x-input-label for="category_id" :value="__('Select Category')" />
                <select name="category_id" id="category_id" class="m-1 border-slate-300 rounded-md w-full">
                    <option value="" selected>-select category-</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" class="m-2" @if (old('category_id') === $category->id)
                            selected
                        @endif>{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
            </div>
            <div class="mt-4">
                <x-input-label for="qty" :value="__('Quantity')" />
                <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full" :value="old('qty')" required />
                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
            </div>
            <div class="mt-4">
                <x-input-label for="unit" :value="__('Unit')" />
                <select name="unit" id="unit" class="m-1 border-slate-300 rounded-md w-full">
                    <option value="">-select unit-</option>
                    <option value="pcs">pcs</option>
                    <option value="kg">kg</option>
                    <option value="box">box</option>
                    <option value="pck">pck</option>
                    <option value="sak">sak</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('unit')" />
            </div>
            <div class="mt-4">
                <x-input-label for="price_per_unit" :value="__('Price/unit in IDR')" />
                <x-text-input id="price_per_unit" name="price_per_unit" type="number" class="mt-1 block w-full" :value="old('price_per_unit')" required />
                <x-input-error class="mt-2" :messages="$errors->get('price_per_unit')" />
            </div>
            <div class="mt-4">
                <x-input-label for="description" :value="__('Product Description')" />
                <textarea name="description" id="description" cols="30" rows="2" class="mt-1 block w-full border border-slate-300 rounded-md" required>{{ old('description') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>
            <div class="mt-4" x-data="{image: null}">
                <x-input-label for="product_picture" :value="__('Product Picture')" />
                <img :src="image" class="w-1/2 md:w-1/2 border-4 border-slate-400 rounded-md overflow-hidden mb-4" x-show="image">
                <input class="w-full md:w-1/2 bg-gray-200 border border-slate-300 rounded-md file:bg-slate-800 file:border-none file:text-white file:p-1" id="product_picture" type="file" name="product_picture" @change="image = URL.createObjectURL($event.target.files[0])">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="product_picture_help">SVG, PNG, JPG or GIF (MAX 2mb).</p>
                <x-input-error class="mt-2" :messages="$errors->get('product_picture')" />
            </div>
            <div class="mt-4">
                <x-primary-button type="submit">submit</x-primary-button>
            </div>
        </form>
    </div>
@endsection