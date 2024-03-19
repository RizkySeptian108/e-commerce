@extends('layouts.app')

@section('main-page')
    <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight text-2xl">
        {{ $page_title }}
    </h2>

    <div class="mt-4 w-full bg-white rounded-md p-3 inline-block">
        @if (session('success'))
            <x-alert color="green">
                {{ session('success') }}
            </x-alert>
        @endif
        <div></div>
        <div class="w-fit">
            <x-dropdown align="left" width="fit">
                <x-slot name="trigger">
                    <x-primary-button class="bg-gray-700 text-white hover:bg-gray-600" type="button">
                        Add Category
                    </x-primary-button>
                </x-slot>
                <x-slot name="content">
                    <form action="category" method="POST" class="p-3">
                        @csrf
                        <x-input-label for="category_name" >
                            <input type="text" name="category_name" id="category_name" placeholder="Category Name..." class="rounded-md border-slate-500">
                        </x-input-label>
                        <x-primary-button type="submit" class="mt-2">
                            submit
                        </x-primary-button>
                    </form>
                </x-slot>
            </x-dropdown>
            @error('category_name')  
                <x-input-error :messages="$message" class="mt-2 "></x-input-error>
            @enderror
        </div>

        <div class="mt-4">
            <table class="border border-slate-500 w-full" >
                <thead>
                    <tr class="bg-slate-400 text-white font-semibold">
                        <th class="border border-slate-500 px-2 py-1 text-center">no</th>
                        <th class="border border-slate-500 px-2 py-1">category</th>
                        <th class="border border-slate-500 px-2 py-1">action</th>
                    </tr>
                </thead>
                <tbody x-data="{update: null}">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="border border-slate-500 px-2 py-1 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-500 px-2 py-1">
                                <span :class="update === {{ $category->id }} ? 'hidden' : ''" >
                                    {{ $category->category_name }}
                                </span>
                                <form action="{{ route('category.update', $category) }}" :class="update === {{ $category->id }} ? 'block' : 'hidden'" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="category_name" value="{{ $category->category_name }}" class="p-1 rounded-md border-slate-400 focus:ring-blue-200">
                                    <x-primary-button type="submit" class="m-1">submit</x-primary-button>
                                </form>
                            </td>
                            <td class="border border-slate-500 px-2 py-1 text-center">
                                <i class="fa-solid fa-pen-to-square mr-2 cursor-pointer text-yellow-500" @click="update === {{ $category->id }} ? update = null : update = {{ $category->id }}"></i>
                                <form action="{{ route('category.destroy', $category) }}" method="POST" class="inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('are you sure?')">
                                        <i class="fa-solid fa-trash cursor-pointer text-red-500"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection