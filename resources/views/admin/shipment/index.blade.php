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
                        Add Shipment Method
                    </x-primary-button>
                </x-slot>
                <x-slot name="content">
                    <form action="shipment-method" method="POST" class="p-3">
                        @csrf
                        <x-input-label for="shipment_method" >
                            <input type="text" name="shipment_method" id="shipment_method" placeholder="insert shipment method" class="rounded-md border-slate-500">
                            <input type="text" name="price" id="price" placeholder="insert price" class="rounded-md border-slate-500 mt-1">
                        </x-input-label>
                        <x-primary-button type="submit" class="mt-2">
                            submit
                        </x-primary-button>
                    </form>
                </x-slot>
            </x-dropdown>
            @error('shipment_method')  
                <x-input-error :messages="$message" class="mt-2 "></x-input-error>
            @enderror
        </div>

        <div class="mt-4">
            <table class="border border-slate-500" >
                <thead>
                    <tr class="bg-slate-400 text-white font-semibold">
                        <th class="border border-slate-500 py-1 text-center">no</th>
                        <th class="border border-slate-500 py-1 px-2">shipment method</th>
                        <th class="border border-slate-500 py-1 px-2">price</th>
                        <th class="border border-slate-500 px-2 py-1">action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipmentMethods as $shipmentMethod)
                        <tr x-data="{update: false, shipmentMethod: '{{ $shipmentMethod->shipment_method }}', price: '{{ $shipmentMethod->price }}'}">
                            <td class="border border-slate-500 px-2 py-1 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-500 px-2 py-1">
                                <span x-show="!update">
                                    {{ $shipmentMethod->shipment_method }}
                                </span>
                                <input type="text" name="shipment_method"  class="p-1 w-20 rounded-md border-slate-400 focus:ring-blue-200" x-show="update" x-model="shipmentMethod" x-cloak>
                            </td>
                            <td class="border border-slate-500 px-2 py-1 text-center">
                                <span x-show="!update">
                                    Rp. {{ number_format($shipmentMethod->price) }}
                                </span>
                                <input type="number" name="price"  class="p-1 w-20 rounded-md border-slate-400 focus:ring-blue-200" x-model="price" x-show="update" x-cloak>
                            </td>
                            <td class="border border-slate-500 px-2 py-1 text-center">
                                <form action="{{ route('shipment-method.update', $shipmentMethod) }}" method="POST" x-cloak>
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" :value="shipmentMethod" name="shipment_method">
                                    <input type="hidden" :value="price" name="price">
                                    <x-primary-button x-show="update">submit</x-primary-button>
                                    <i class="fa-solid fa-xmark text-red-600 cursor-pointer" @click="update = !update" x-show="update"></i>
                                </form>
                                <i class="fa-solid fa-pen-to-square mr-2 cursor-pointer text-yellow-500" @click="update = !update" x-show="!update"></i>
                                <form action="{{ route('shipment-method.destroy', $shipmentMethod) }}" method="POST" :class="{'hidden': update}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('are you sure?')" x-show="!update">
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