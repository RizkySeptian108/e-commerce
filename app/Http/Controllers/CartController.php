<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;
use PDO;

class CartController extends Controller
{

    public function index()
    {

        $carts = Cart::with(['product:id,product_name,product_picture,price_per_unit,unit,qty'])
                 ->where('carts.user_id', Auth::user()->id)
                 ->join('kiosks', 'carts.kiosk_id', '=', 'kiosks.id')
                 ->select('carts.*', 'kiosks.kiosk_name', 'kiosks.kiosk_logo')
                 ->get();

        $orders = [];
        $order = [
            'kiosk' => [
                'kiosk_id' => null,
                'kiosk_name' => null,
                'kiosk_logo' => null,
            ],
            'isKioskChecked' => false,
            'items' => [],
        ];

        foreach($carts as $cart){
            $cart->isItemChecked = false;

            if($cart->kiosk_id !== $order['kiosk']['kiosk_id']){
                $order['kiosk']['kiosk_id'] = $cart->kiosk_id;
                $order['kiosk']['kiosk_name'] = $cart->kiosk_name;
                $order['kiosk']['kiosk_logo'] = $cart->kiosk_logo;
                $order['items'] = [];
                array_push($order['items'], $cart);
                array_push($orders, $order);    
            }else{
                array_push($order['items'], $cart);
                foreach($orders as $key => $ord){
                    if($cart->kiosk_id === $ord['kiosk']['kiosk_id']){
                        $orders[$key] = $order;
                    }
                }
            }
        }

        return view('cart', [
            'page_title' => 'Cart',
            'sidebar' => true,
            'carts' => collect($orders),
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
