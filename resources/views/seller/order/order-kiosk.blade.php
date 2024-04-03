@extends('layouts.app')

@section('main-page')
    <x-title>
        Orders
    </x-title>
    <div class="mt-4 p-4 bg-white rounded-md">
        {{-- Filter --}}

        @if (session('not_confirm'))
            <x-alert color="red">
                {{ session('not_confirm') }}
            </x-alert>
        @endif
        {{-- main content --}}
        @if ($orders->links())    
            <div class="mt-2">
                {{ $orders->links() }}
            </div>
        @endif
        @foreach ($orders as $order)    
        <div class="flex flex-col gap-2">
            <div class="rounded-lg shadow">
                <div class="flex gap-2 items-center w-full p-2 bg-gray-200 rounded-t-lg ">
                    <p class="font-bold">{{ $order->user->name }}</p>
                    <p class="text-sm font-light">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex flex-col md:flex-row p-2 w-full gap-2 justify-between">
                    <div class="flex gap-2 flex-col">
                        @foreach ($order->orderItems as $item) 
                        <div class="flex gap-2">
                            <img src="{{ asset('storage/' . $item->product->product_picture) }}" alt="{{ $item->product->product_name }}" class="w-16 h-16">
                            <div>
                                <p class="font-bold">{{ $item->product->product_name }}</p>
                                <p class="text-xs opacity-70">{{ $item->qty }} x {{ number_format($item->product->price_per_unit) }}, total {{ number_format($item->qty * $item->product->price_per_unit) }} </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="">
                        <p class="font-extrabold">Address</p>
                        <p>{{ $order->address }}</p>
                    </div>
                    <div>
                        <p class="font-extrabold">Total</p>
                        @php
                            $total = 0;
                            foreach ($order->orderItems as $item) {
                                $total += $item->qty * $item->product->price_per_unit;
                            }
                        @endphp
                        <p class="font-extrabold text-orange-400">
                            Rp. {{ number_format($total) }}
                        </p>
                    </div>
                </div>
                <div class="w-full flex justify-end gap-2 p-2">
                    <form action="{{ route('order.update', [$order, 'status' => 'confirm']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button 
                        @if (!$order->is_confirm)
                            class="rounded-md bg-green-700 shadow p-1 text-white uppercase font-bold"
                        @else
                            class="rounded-md bg-slate-200 shadow p-1 text-black uppercase font-bold hover:cursor-not-allowed"
                        @endif
                        >Confirm</button>
                    </form>
                    <form action="{{ route('order.update', [$order, 'status' => 'deliver']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button 
                        @if (!$order->is_packed)
                            class="rounded-md bg-blue-700 shadow p-1 text-white uppercase font-bold"
                        @else
                            class="rounded-md bg-slate-200 shadow p-1 text-black uppercase font-bold hover:cursor-not-allowed"
                        @endif
                        >Deliver</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @if ($orders->links())    
            <div class="mt-2">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection