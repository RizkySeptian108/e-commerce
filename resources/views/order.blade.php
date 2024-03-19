@extends('layouts.app')

@section('main-page')
    <div class="lg:px-12 px-3 py-2">
        <h1 class="font-bold text-2xl uppercase">Order</h1>
        <form action="{{ route('order.store') }}" method="POST"
            x-data="{
                carts: {{ $carts }},
                paymentMethod: [],
                totalPrice: function(){
                    let price = 0;
                    let carts = this.carts
                    
                    carts.forEach(function(cart){
                        cart.items.forEach(function(item){
                            price += item.product.price_per_unit * item.order_qty 
                        })
                        price += cart.shipment.price
                    })
                    return price;
                },
                changeShipment: function(index, price, shipment_method, shipment_id){
                    this.carts[index].shipment.price = price; 
                    this.carts[index].shipment.shipment_method = shipment_method; 
                    this.carts[index].shipment.shipment_id = shipment_id; 
                }
            }"
        >
            @csrf
            <div class="md:grid grid-cols-12 mt-4 gap-2">
                <div class="col-span-8">
                    {{-- Address and costumer detail start --}}
                    <div class="bg-white p-4 rounded-t-xl shadow mb-4">
                        <input type="hidden" name="address" id="address" value="{{ Auth::user()->address }}">
                        <h3 class="opacity-50 font-bold text-sm">DELIVERY ADDRESS</h3>
                        <p class="font-bold mt-2"><i class="fa-solid fa-location-dot text-green-600"></i> Home . <span>{{ Auth::user()->name }}</span></p>
                        <p class="text-sm">{{ Auth::user()->address }}</p>
                    </div>
                    {{-- Address and costumer detail start --}}

                    {{-- shipment input error message start --}}
                    @error('address')
                        <x-alert color="red">
                            {{ $message }}
                        </x-alert>
                    @enderror
                    @error('orders.*.shipment_id')
                        <x-alert color="red">
                            {{ $message }}
                        </x-alert>
                    @enderror
                    {{-- shipment input error message end --}}

                    {{-- Loop the carts --}}
                    <div class="bg-white shadow p-2 max-w-full">
                        <template x-for="(cart, index) in carts">
                            <div x-data="{
                                totalPerOrder: function(items){
                                    price = 0;
                                    items.forEach(function(item){
                                        price += item.product.price_per_unit * item.order_qty
                                    })
                                    price += cart.shipment.price
                                    return price;
                                }
                            }">
                                {{-- kiosk logo & name --}}
                                <div class="mt-4 flex items-center gap-3">
                                    <img :src="'{{ asset('storage') }}/' + cart.kiosk.kiosk_logo" :alt="cart.kiosk_name" class="w-7 h-7 border border-slate-400 rounded-full shadow-sm">
                                    <input type="hidden" :name="'orders['+index+'][kiosk_id]'" :value="cart.kiosk.kiosk_id">
                                    <span x-text="cart.kiosk.kiosk_name" class="text-sm font-bold "></span>
                                </div>

                                <input type="hidden" :name="'orders['+index+'][totalPerOrder]'" :value="totalPerOrder(cart.items)">

                                {{-- items detail start --}}
                                <div >
                                    <template x-for="(item, i) in cart.items">
                                        <div class="flex gap-2 mt-2">                                            
                                            <img  :src="'{{ asset('storage') }}' + '/' + item.product.product_picture" :alt="item.product.product_name"  class=" w-28 rounded-md shadow" >
                                            <div class="flex max-sm:flex-col justify-between flex-grow">
                                                <div class="">
                                                    <input type="hidden" :name="'orders['+ index +'][items]['+i+'][cart_id]'" :value="item.id">
                                                    <input type="hidden" :name="'orders['+ index +'][items]['+i+'][product_id]'" :value="item.product_id">
                                                    <input type="hidden" :name="'orders['+ index +'][items]['+i+'][order_qty]'" :value="item.order_qty">
                                                    <p class="text-ellipsis uppercase" x-text="item.product.product_name"></p>
                                                    <p class="text-sm opacity-80">Unit: <span x-text="item.product.unit"></span></p>
                                                </div>
                                                <div class="text-xs md:text-sm md:text-end ">
                                                    <p class="font-bold" id="totalPerProduct" x-text="(item.product.price_per_unit * item.order_qty).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })" ></p>
                                                    <p class="opacity-80"><span x-text="item.order_qty"></span> x <span x-text="item.product.price_per_unit.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Shipment methods --}}
                                    <div class="md:grid grid-cols-12 mt-6 pr-4">
                                        <div class="col-span-10 col-start-3 relative" x-data="{
                                            shipments: {{ $shipments }}, 
                                            open: false, 
                                        }" >
                                            <div class="flex justify-between cursor-pointer border border-slate-400 rounded-md p-2" x-on:click="open = !open" x-on:click.outside="open = false">
                                                <input type="hidden" :name="'orders['+ index +'][shipment_id]'" :value="cart.shipment.shipment_id">
                
                                                {{-- showing shipment that are chosen start --}}
                                                <span x-text="cart.shipment.shipment_method" class="uppercase font-bold"></span>
                                                <span>
                                                    <span x-text="cart.shipment.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })" class="mr-5 text-sm font-bold"></span><i class="fa-solid fa-caret-down"></i>
                                                </span>
                                                {{-- showing shipment that are chosen end --}}
                
                                            </div>
                                            <div class="border border-slate-300 p-2 rounded-md mt-2 absolute bottom-12 w-full bg-white" x-show="open === true" x-transition>
                                                {{-- looping the shipment methods start --}}
                                                <template x-for="shipment in shipments">
                                                    <div class="flex justify-between cursor-pointer px-2 py-1 hover:bg-slate-200 rounded-md" x-on:click="changeShipment(index, shipment.price, shipment.shipment_method, shipment.id)">
                                                        <span x-text="shipment.shipment_method" class="uppercase font-bold text-sm"></span>
                                                        <span class="text-sm" x-text="shipment.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span>
                                                    </div>
                                                </template>
                                                {{-- looping the shipment methods end --}}
                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- items detail end --}}
                            </div>
                        </template>
                    </div>
                </div>
                
                {{-- Shopping Summary --}}
                <div class="col-span-4 max-sm:sticky bottom-0 max-sm:mt-2">
                    <div class="w-full bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg text-center">Shopping summary</h3>

                        {{-- total price --}}
                        <div class="flex justify-between mt-2 items-center">
                            <span class="text-sm flex justify-between w-full items-center">Total : <span class="text-lg" x-text="totalPrice().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span></span>
                        </div>

                        {{-- delivery prices --}}
                        <template x-for="cart in carts">
                            <div class="flex justify-between mt-2 items-center text-sm" x-show="cart.shipment.price > 0">
                                <span class="w-1/3">
                                    <span x-text="cart.kiosk.kiosk_name"></span>
                                </span>
                                <span class="w-2/3 flex justify-between">
                                    <span class="text-xs" x-text="cart.shipment.shipment_method"></span>
                                    <span x-text="cart.shipment.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span>
                                </span>
                            </div>
                        </template>
                        

                        <input type="hidden" name="total_price" :value="totalPrice()">
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

