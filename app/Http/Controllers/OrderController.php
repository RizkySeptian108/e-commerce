<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\ShipmentMethod;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderRequest $request)
    {
        $carts = [];

        foreach($request->order as $order){
            $cart = Cart::find($order['cart_id']);
            $cart->load('product:id,product_name,product_picture,price_per_unit,unit', 'kiosk:id,kiosk_logo,kiosk_name');
            $cart->order_qty = $order['qty'];
            array_push($carts, $cart);
        }

        $carts = collect($carts);
        
        $shipments = ShipmentMethod::all();

        $paymentMethods = PaymentMethod::all();

        return view('order', [
            'page_title' => 'Order',
            'sidebar' => true,
            'carts' => $carts->sortBy('kiosk_id'),
            'shipments' => $shipments,
            'totalItems' => $request->total,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return $request;
       $request->validate([
            'orders' => 'required|array',
            'payment_method' => 'required',
            'address' => 'required',
            'orders.*.shipment_id' => 'required'
       ], [
            'orders.*.shipment_id.required' => 'shipment method for all orders are required',
            'payment_method.required' => 'please select payment method' 
       ]);

       foreach($request->orders as $key => $order){
            $recordedData = Order::create([
                'user_id' => Auth::user()->id,
                'kiosk_id' => $order['kiosk_id'],
                'address' => $request->address,
                'payment_id' => $request->payment_method,
                'shipment_id' => $order['shipment_id'],
            ]);

            $total_price = 0;

            foreach($order['order_items'] as $item){
                $item = OrderItem::create([
                    'order_id' => $recordedData->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty']
                ]);

                $total_price += $item->product->price_per_unit * $item->qty;
            }

            Order::where('id', $recordedData->id)
                    ->update([
                        'total_price' => $total_price
                    ]);
                    
       }

       return redirect('/');

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
