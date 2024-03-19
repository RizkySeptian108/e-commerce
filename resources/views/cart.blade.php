@extends('layouts.app')

@section('main-page')

    <div class="py-3 lg:px-12 w-full p-2">
        <h1 class="font-bold text-2xl uppercase">Cart</h1>

        @if($errors->any())
            {{-- <x-alert color="red">
                You need to checklist the items you want to buy!
            </x-alert> --}}
            {{ $errors }}
        @endif

        <form action="{{ route('order.create') }}" method="get" x-data="{
            total: function(){
                let totalPrice = 0
                this.carts.forEach(function(cart){
                    cart.items.forEach(function(item){
                        if(item.isItemChecked == true){
                            totalPrice += item.product.price_per_unit * item.qty
                        }
                    }) 
                })
                return totalPrice
            },
            allChecked: false,
            carts: {{ $carts }},
            checked: function(){
                if(this.allChecked == true){
                    this.carts.forEach(function(cart){
                        cart.isKioskChecked = true
                        cart.items.forEach(item => item.isItemChecked = true)
                    })
                }else{
                    this.carts.forEach(function(cart){
                        cart.isKioskChecked = false
                        cart.items.forEach(item => item.isItemChecked = false)
                    })
                }
            },
            isAllChecked: function(){
                items = this.carts.every(cart => cart.isKioskChecked == true)
                if(items == true){
                    this.allChecked = true
                }else{
                    this.allChecked = false
                }
                {{-- if(this.carts.length <= 0){
                    items = false
                } --}}
                return items
            }
        }">
            <div class="lg:grid grid-cols-12 mt-4 gap-2">
                <div class="col-span-9">
                    {{-- Check all button --}}
                    <div class="bg-white p-4 rounded-t-xl shadow">
                        <input type="checkbox" class="mr-2 rounded-md w-5 h-5" id="check_all" 
                        x-on:change="allChecked = !allChecked; checked()" x-bind:checked=" isAllChecked()">
                        <span class="font-extrabold">Check all</span>
                    </div>
                    @csrf
                    <template x-if="carts.length > 0">
                        <template x-for="(cart, indexKiosk) in carts">
                            <div class="border-b p-4 bg-white shadow" 
                                x-data="{
                                    isItemCheckedFunc: function(){
                                        cart.items.forEach(function(item){
                                            if(cart.isKioskChecked == true){
                                                item.isItemChecked = true
                                            }else{
                                                item.isItemChecked = false
                                            }
                                        })
                                    },
                                    allItems: function(){
                                        items = cart.items.every(item => item.isItemChecked == true)
                                        if(items == true){
                                            cart.isKioskChecked = true
                                        }else{
                                            cart.isKioskChecked = false
                                        }
                                        return items
                                    },
                                    
                                }"
                            >
                                {{-- kiosk logo and checklist --}}
                                <div class="mb-2 flex items-center font-bold gap-1" id="kiosk_checkbox">
                                    <input type="checkbox" :value="cart.kiosk.kiosk_id" :name="'orders['+indexKiosk+'][kiosk_id]'" class="mr-2 rounded-md w-5 h-5 col-span-1" x-on:change="
                                    cart.isKioskChecked = !cart.isKioskChecked; 
                                    isItemCheckedFunc();
                                    "
                                    x-bind:checked="allItems()" 
                                    >
                                    <input type="hidden" :name="'orders['+indexKiosk+'][kiosk_id]'" :value="cart.kiosk.kiosk_id">
                                    <img :src="'{{ asset('storage') }}/' + cart.kiosk.kiosk_logo" :alt="cart.kiosk_name" class="w-7 h-7 border border-slate-400 rounded-full shadow-sm">
                                    <h3 x-text="cart.kiosk.kiosk_name"></h3>
                                </div>
    
                                {{-- Items loop --}}
                                <template x-for="(item, indexItem) in cart.items">
                                <div x-data="{
                                        max: item.product.qty,
                                        price: item.product.price_per_unit,
                                        totalPerItem: function(){
                                            return this.price * item.qty
                                        },
                                    }
                                " class="mb-2">
                                    <div class="flex gap-2 font-semibold">
                                        <input type="checkbox" class="mr-2 rounded-md w-5 h-5 col-span-1" id="product_check" :name="'orders['+indexKiosk+'][items]['+indexItem+'][cart_id]'" x-on:change="
                                            item.isItemChecked = !item.isItemChecked;
                                            cart.isKioskChecked = true
                                        " 
                                        :value="item.id"
                                        x-bind:checked="item.isItemChecked == true? true : false"
                                        >
                                        <img  :src="'{{ asset('storage') }}' + '/' + item.product.product_picture" :alt="item.product_name"  class="col-span-2 w-16 md:w-28" >
                                        <div class="md:flex flex-row w-full">
                                            <p class="col-span-6 text-ellipsis" x-text="item.product.product_name"></p>
                                            <p class="col-span-3 w-full text-xs md:text-base md:text-end" id="totalPerProduct" x-text="(price * item.qty).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })" ></p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mt-1 flex justify-end items-center gap-2">
                                            <form :action="'cart/cart-delete/' + item.id" method="POST">
                                                @csrf
                                                <button class="mr-4 text-slate-600 cursor-pointer" ><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                            <span class="inline-block">Stock: <span x-text="item.product.qty"></span></span>
                                            <div class="flex gap-2 border rounded-xl border-slate-300 px-2 py-1 w-fit focus:outline-none">
                                                <button type="button" x-on:click="item.qty <= 1 ? '' : item.qty-- " ><i class="fa-solid fa-minus"></i></button>
                                                <input 
                                                type="number" 
                                                readonly  
                                                min="0" 
                                                :name="'orders['+indexKiosk+'][items]['+indexItem+'][qty]'" 
                                                x-model="item.qty" 
                                                class="w-10 p-0 text-center border-none [&::-webkit-inner-spin-button]:appearance-none border-transparent focus:border-transparent focus:ring-0" 
                                                x-bind:disabled="!item.isItemChecked"
                                                >
                                                <button type="button" x-on:click="item.qty >= max ? '' : item.qty++" ><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </template>
    
    
                            </div>
                        </template>
                    </template>
                    <template x-if="carts.length <= 0">
                        <div class="bg-white w-full text-center mt-4 mb-4 p-3">
                            <p class="opacity-70">You haven't choose any item yet!!</p>
                        </div>
                    </template>
                </div>

                {{-- Shopping summary --}}
                <div class="col-span-3 sticky bottom-0 lg:static w-full max-sm:mt-4">
                    <div class="w-full bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg text-center">Shopping summary</h3>
                        <div class="flex justify-between mt-2 items-center">
                            <span class="text-sm flex justify-between w-full items-center">Total : <span class="text-lg" x-text="total().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })"></span></span>
                        </div>
                        <input type="hidden" x-bind:value="total()" name="total">
                        <x-primary-button class="mt-2 w-full">Buy</x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection