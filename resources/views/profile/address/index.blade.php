@extends('layouts.app')

@section('main-page')

<div class="ms-10 me-10">

    @if(session('success'))
        <x-alert color="green" >{{ session('success') }}</x-alert>
    @elseif (session('error'))
        <x-alert color="red" >{{ session('error') }}</x-alert>
    @endif

    <x-title>Address Setting</x-title>

    <div class="mt-5 p-8 bg-white dark:bg-gray-400 shadow rounded-lg">
        <x-button-link href="{{ route('address.create') }}" >+ Add New Address</x-button-link>
        <div class="mt-4 flex flex-col gap-2">
            @foreach ($addresses as $address)
                <div class="p-3 border-2 @if($address->is_main) border-lime-500 @else border-slate-200 @endif rounded-xl dark:bg-slate-300 w-full flex justify-between overflow-auto">
                    <div>
                        <h4 class="font-bold text-sm">{{ $address->address_label }}</h4>
                        <h4 class="font-bold">{{ $address->recipient_name }}</h4>
                        <p class="text-sm">{{ $address->phone_number }}</p>
                        <p>{{ $address->full_address }}</p>
                    </div>
                    <div class="flex flex-col items-center align-middle">
                        {{-- <form action="{{ route('address.status', $address->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-circle-check text-lime-500"></i>
                            </button>
                        </form> --}}
                        <a href="{{ route('address.status', $address->id) }}">
                            <i class="fa-solid fa-circle-check text-lime-500"></i>
                        </a>
                        <a href="{{ route('address.edit', $address->id) }}">
                            <i class="fa-solid fa-pen-to-square cursor-pointer text-yellow-500 dark:text-yellow-500"></i>
                        </a>
                        <form action="{{ route('address.destroy', $address->id) }}" method="POST" class="inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" onclick="return confirm('are you sure?')">
                                <i class="fa-solid fa-trash cursor-pointer text-red-500 dark:text-red-700"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection