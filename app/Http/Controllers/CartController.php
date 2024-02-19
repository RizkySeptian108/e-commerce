<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CartController extends Controller
{

    public function index()
    {
        // $carts = Cart::with(['product:id,product_name,product_picture,price_per_unit,unit,kiosk_id,qty' => ['kiosk:id,kiosk_name',]])->where('user_id', Auth::user()->id)->get();

        $carts = Cart::with(['product:id,product_name,product_picture,price_per_unit,unit,qty'])
                 ->where('carts.user_id', Auth::user()->id)
                 ->join('kiosks', 'carts.kiosk_id', '=', 'kiosks.id')
                 ->select('carts.*', 'kiosks.kiosk_name')
                //  ->orderBy('carts.created_at', 'DESC')
                 ->orderBy('kiosks.kiosk_name', 'DESC')
                 ->get();

        foreach($carts as $cart){
            $cart->isChecked = false;
        }
                        
        return view('cart', [
            'page_title' => 'Cart',
            'sidebar' => true,
            'carts' => $carts,
            ]);
    }

    public function store(Product $product, Request $request)
    {
        $request->validate([
            'qty' => 'numeric|min:1'
        ]);

        $data = [
            'user_id' => Auth::user()->id,
            'qty' => $request->qty,
            'product_id' => $product->id,
            'kiosk_id' => $product->kiosk_id
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

    public function destroy(Cart $cart){
        Cart::destroy('id', $cart->id);

        return redirect('/carts');
    }
}
