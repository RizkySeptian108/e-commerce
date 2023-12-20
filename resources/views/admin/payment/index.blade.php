@extends('layouts.app')

@section('main-page')
    <x-title>
        {{ $page_title }}
    </x-title>

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
                        Add Payment Method
                    </x-primary-button>
                </x-slot>
                <x-slot name="content">
                    <form action="payment-method" method="POST" class="p-3">
                        @csrf
                        <x-input-label for="payment_method" >
                            <input type="text" name="payment_method" id="payment_method" placeholder="insert payment_method" class="rounded-md border-slate-500">
                        </x-input-label>
                        <x-primary-button type="submit" class="mt-2">
                            submit
                        </x-primary-button>
                    </form>
                </x-slot>
            </x-dropdown>
            @error('payment_method')  
                <x-input-error :messages="$message" class="mt-2 "></x-input-error>
            @enderror
        </div>

        <div class="mt-4">
            <table class="border border-slate-500" >
                <thead>
                    <tr class="bg-slate-400 text-white font-semibold">
                        <th class="border border-slate-500 px-2 py-1 text-center">no</th>
                        <th class="border border-slate-500 px-28 py-1">category</th>
                        <th class="border border-slate-500 px-2 py-1">action</th>
                    </tr>
                </thead>
                <tbody x-data="{update: null}">
                    @foreach ($PaymentMethods as $PaymentMethod)
                        <tr>
                            <td class="border border-slate-500 px-2 py-1 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-500 px-2 py-1">
                                <span :class="update === {{ $PaymentMethod->id }} ? 'hidden' : ''" >
                                    {{ $PaymentMethod->payment_method }}
                                </span>
                                <form action="{{ route('payment-method.update', $PaymentMethod) }}" :class="update === {{ $PaymentMethod->id }} ? 'block' : 'hidden'" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="payment_method" value="{{ $PaymentMethod->payment_method }}" class="p-1 rounded-md border-slate-400 focus:ring-blue-200">
                                    <x-primary-button type="submit">submit</x-primary-button>
                                </form>
                            </td>
                            <td class="border border-slate-500 px-2 py-1 text-center">
                                <i class="fa-solid fa-pen-to-square mr-2 cursor-pointer text-yellow-500" @click="update === {{ $PaymentMethod->id }} ? update = null : update = {{ $PaymentMethod->id }}"></i>
                                <form action="{{ route('payment-method.destroy', $PaymentMethod) }}" method="POST" class="inline">
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