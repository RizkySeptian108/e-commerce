@extends('layouts.app')

@section('main-page')
    
    <div class="py-3 px-12">
        <h1 class="font-bold text-2xl uppercase">Cart</h1>

        @if($errors->any())
            <x-alert color="red">
                You need to checklist the items you want to buy!
            </x-alert>
        @endif

        <form action="{{ route('order.create') }}" method="get" x-data="{
            numbers: [],
            total: function(){
                let price = 0;
                let numbers = this.numbers;
                for(let i = 0; i < numbers.length; i++){
                    price += numbers[i];
                }
                return price;
            },
            allChecked: false,
            carts: {{ $carts }},
            checked: function(){
                if(allChecked == true){
                    this.cart.isChecked = true
                }
            },
            kioskName: null,
            kioskFunc: function(cartKioskID){
                if(this.kioskName !== cartKioskID){
                    this.kioskName = cartKioskID;
                    return true
                }else{
                    return false
                }
            }
        }">
            <div class="grid grid-cols-12 mt-4 gap-2">
                @csrf
                <div class="col-span-9 shadow">
                    <div class="bg-white p-4 rounded-t-xl shadow">
                        <input type="checkbox" class="mr-2 rounded-md w-5 h-5" id="check_all" 
                        x-on:change="
                            allChecked = !allChecked; 
                            carts.forEach(cart => cart.isChecked = allChecked);
                        "  
                        x-bind:checked="allChecked">
                        <span class="font-extrabold">Check all</span>
                    </div>
                    
                    <template x-for="(cart, index) in carts">
                    <div class="border-b p-4 bg-white shadow" 
                    x-data="{
                        qty: cart.qty, 
                        max: cart.product.qty,
                        price: cart.product.price_per_unit,
                        totalPerItem: function(){
                            return this.price * this.qty
                        },
                    }
                    ">
                        <template x-if="kioskFunc(cart.kiosk_id)">
                            <div class="mb-2 flex items-center font-bold gap-1" id="kiosk_checkbox">
                                <input type="checkbox" class="mr-2 rounded-md w-5 h-5 col-span-1" >
                                <h3 x-text="cart.kiosk_name"></h3>
                            </div>
                        </template>

                        <div class="grid grid-cols-12 gap-2">
                            <input type="checkbox" 
                            :name="'order[' + index + '][cart_id]'" 
                            class="mr-2 rounded-md w-5 h-5 col-span-1" 
                            :value="cart.id" 
                            x-bind:checked="cart.isChecked == true? true : false" 
                            x-on:change="
                                cart.isChecked = !cart.isChecked; 
                                allChecked == true? allChecked = false : '';
                                let checkedAll = carts.every(cart => cart.isChecked)
                                if(checkedAll){
                                    allChecked = true;
                                }
                                " 
                            id="product_check" 
                            :click="cart.isChecked == true ? numbers[index] = totalPerItem() : numbers[index] = 0" 
                            >
                            <img  :src="'{{ asset('storage') }}' + '/' + cart.product.product_picture" :alt="cart.product.product_name"  class="col-span-2 w-28" >
                            <p class="col-span-6 text-ellipsis" x-text="cart.product.product_name"></p>
                            <p class="col-span-3" id="totalPerProduct" x-text="(price * qty).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 2, })" ></p>
                        </div>
                        <div class="mt-1 flex justify-end items-center gap-2">
                            <form :action="'cart/cart-delete/' + cart.id" method="POST">
                                @csrf
                                <button class="mr-4 text-slate-600 cursor-pointer" ><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                            <span class="inline-block">Stock: <span x-text="cart.product.qty"></span></span>
                            <div class="flex gap-2 border rounded-xl border-slate-300 px-2 py-1 w-fit focus:outline-none">
                                <button type="button" x-on:click="qty <= 1 ? '' : qty-- " ><i class="fa-solid fa-minus"></i></button>
                                <input 
                                type="number" 
                                readonly  
                                min="0" 
                                :name="'order[' + index + '][qty]'" 
                                x-model="qty" 
                                class="w-10 p-0 text-center border-none [&::-webkit-inner-spin-button]:appearance-none border-transparent focus:border-transparent focus:ring-0" 
                                x-bind:disabled="!cart.isChecked"
                                >
                                <button type="button" x-on:click="qty >= max ? '' : qty++" ><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    </template>
                </div>
                
                <div class="col-span-3">
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