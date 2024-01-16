<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Product $product, Request $request)
    {
        $request->validate([
            'qty' => 'numeric|min:1'
        ]);

        $data = [
            'user_id' => Auth::user()->id,
            'qty' => $request->qty,
            'product_id' => $product->id
        ];

        $cart = Cart::where(['user_id' => Auth::user()->id, 'product_id' => $product->id])->first();

        if($cart){
            Cart::where(['user_id' => Auth::user()->id, 'product_id' => $product->id])
                    ->update(['qty' => $cart->qty + $data['qty']]);
        }else{
            Cart::create($data);
        }
        
        return redirect(route('home-product', ['product' => $product->id]));
    }

    public function shows(Request $request)
    {
        $data = Cart::where('user_id', $request->user_id)->with(['product'])->get();

        return response()->json(['carts' => $data]);
    }
}
