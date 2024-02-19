@extends('layouts.app')

@section('main-page')
    <div class="px-12 py-3">
        <h1 class="font-bold text-2xl uppercase">Order</h1>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf

            {{-- Alpine logic --}}
            <div class="grid grid-cols-12 mt-4 gap-2" x-data="{
                carts: {{ $carts }}, 
                kiosk: null, 
                kioskFunc: function(id){
                    if(this.kiosk !== id){
                        this.kiosk = id;
                        this.order++;
                        return true
                    }else{
                        return false
                    } 
                },
                deliveryFunc: function(currentId, nextId){
                    if(currentId !== nextId){
                        return true
                    }else{
                        return false
                    }
                },
                totalItems: {{ $totalItems }},
            }">

                <div class="col-span-9">
                    {{-- Address and costumer detail start --}}
                    <div class="bg-white p-4 rounded-t-xl shadow mb-4">
                        <input type="hidden" name="address" id="address" value="{{ Auth::user()->address }}">
                        <h3 class="opacity-50 font-bold text-sm">DELIVERY ADDRESS</h3>
                        <p class="font-bold mt-2"><i class="fa-solid fa-location-dot text-green-600"></i> Home . <span>{{ Auth::user()->name }}</span></p>
                        <p class="text-sm">{{ Auth::user()->address }}</p>
                    </div>
                    {{-- Address and costumer detail start --}}

                    {{-- shipment input error message start --}}
                    @error('orders.*.shipment_id')
                        <x-alert color="red">
                            {{ $message }}
                        </x-alert>
                    @enderror
                    {{-- shipment input error message end --}}

                    <div class="mt-4 bg-white shadow">
                        <div class="p-2">

                            {{-- Looping the items start --}}
                            <template x-for="(cart, i) in carts">
                                <div>

                                    {{-- showing the kiosk once using if start --}}
                                    <template x-if="kioskFunc(cart.kiosk_id)">
                                        <div class="mt-4 flex items-center gap-3">
                                            <img :src="'{{ asset('storage') }}/' + cart.kiosk.kiosk_logo" :alt="cart.kiosk_name" class="w-7 h-7 border border-slate-400 rounded-full shadow-sm">
                                            <input type="hidden" :name="'orders['+ order +'][kiosk_id]'" :value="cart.kiosk_id">
                                            <span x-text="cart.kiosk.kiosk_name" class="text-sm font-bold "></span>
                                        </div>
                                    </template>
                                    {{-- showing the kiosk once using if start --}}

                                    {{-- items detail start --}}
                                    <div class="grid grid-cols-12 gap-2 mt-2">
                                        <img  :src="'{{ asset('storage') }}' + '/' + cart.product.product_picture" :alt="cart.product.product_name"  class="col-span-2 w-28 rounded-md shadow" >
                                        <div class="col-span-7">
                                            <input type="hidden" :name="'orders['+ order +'][order_items]['+ i +'][product_id]'" :value="cart.product_id">
                                            <input type="hidden" :name="'orders['+ order +'][order_items]['+ i +'][qty]'" :value="cart.order_qty">
                                            <p class="text-ellipsis uppercase" x-text="cart.product.product_name"></p>
                                            <p class="text-sm opacity-80">Unit: <span x-text="cart.product.unit"></span></p>
                                        </div>
                                        <div class="col-span-3 text-end px-4">
                                            <p class="text-sm font-bold" id="totalPerProduct" x-text="(cart.product.price_per_unit * cart.order_qty).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })" ></p>
                                            <p class="text-sm opacity-80"><span x-text="cart.order_qty"></span> x <span x-text="cart.product.price_per_unit.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span></p>
                                        </div>
                                    </div>
                                    {{-- items detail end --}}
                                    
                                    {{-- showing the shipment methods at the end of the same kiosk start --}}
                                    <template x-if="carts[i + 1]? deliveryFunc(cart.kiosk_id, carts[i + 1].kiosk_id) : deliveryFunc(cart.kiosk_id, 0)">
                                        <div class="grid grid-cols-12 mt-6 pr-4">
                                            <div class="col-span-10 col-start-3 relative" x-data="{
                                                shipments: {{ $shipments }}, 
                                                open: false, 
                                                shipmentName: 'select shipment',
                                                shipmentPrice: 0,
                                                shipmentId: null
                                            }" >
                                                <div class="flex justify-between cursor-pointer border border-slate-400 rounded-md p-2" x-on:click="open = !open" x-on:click.outside="open = false">
                                                    <input type="hidden" :name="'orders['+ order +'][shipment_id]'" :value="shipmentId" on>

                                                    {{-- showing shipment that are chosen start --}}
                                                    <span x-text="shipmentName" class="uppercase font-bold"></span>
                                                    <span>
                                                        <span x-text="shipmentPrice.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })" class="mr-5 text-sm font-bold"></span><i class="fa-solid fa-caret-down"></i>
                                                    </span>
                                                    {{-- showing shipment that are chosen end --}}

                                                </div>
                                                <div class="border border-slate-300 p-2 rounded-md mt-2 absolute bottom-12 w-full bg-white" x-show="open === true" x-transition>
                                                    {{-- looping the shipment methods start --}}
                                                    <template x-for="shipment in shipments">
                                                        <div class="flex justify-between cursor-pointer px-2 py-1 hover:bg-slate-200 rounded-md" x-on:click="shipmentName = shipment.shipment_method; shipmentPrice = shipment.price; shipmentId = shipment.id">
                                                            <span x-text="shipment.shipment_method" class="uppercase font-bold text-sm"></span>
                                                            <span class="text-sm" x-text="shipment.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span>
                                                        </div>
                                                    </template>
                                                    {{-- looping the shipment methods end --}}

                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- showing the shipment methods at the end of the same kiosk start --}}

                                </div>
                            </template>
                            {{-- Looping the items end --}}

                        </div>
                    </div>
                </div>
                
                <div class="col-span-3">
                    <div class="w-full bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg text-center">Shopping summary</h3>

                        {{-- total price --}}
                        <div class="flex justify-between mt-2 items-center">
                            <span class="text-sm flex justify-between w-full items-center">Total : <span class="text-lg" x-text="totalItems.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span></span>
                        </div>

                        {{-- delivery prices --}}
                        <div class="flex justify-between mt-2 items-center">
                            <span class="text-sm flex justify-between w-full items-center">shipment 1: <span>Rp10.000</span></span>
                        </div>

                        <input type="hidden" :value="totalItems" name="total">
                        <select name="payment_method" id="payment_method" class="mt-4 w-full rounded-md border-slate-400">
                            <option value="">select payment method</option>
                            @foreach ($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <span class="text-sm text-red-800 justify-end text-end">{{ $message }}</span>
                        @enderror
                        <x-primary-button class="mt-2 w-full">Buy</x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection