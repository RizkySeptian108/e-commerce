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

        $order = [
            'kiosk' => [
                'kiosk_id' => null,
                'kiosk_name' => null,
                'kiosk_logo' => null
            ],
            'items' => [],
            'shipment' => [
                'shipment_id' => '',
                'shipment_method' => 'CHOOSE SHIPMENT METHOD',
                'price' => 0
            ]
        ];

        foreach($request->order as $item){
            $cart = Cart::find($item['cart_id'], ['id', 'product_id', 'kiosk_id', 'qty']);
            $cart->load('product:id,product_name,product_picture,price_per_unit,unit', 'kiosk:id,kiosk_logo,kiosk_name');
            $cart->order_qty = $item['qty'];
            
            if($cart['kiosk_id'] !== $order['kiosk']['kiosk_id']){
                $order['kiosk']['kiosk_id'] = $cart->kiosk_id;
                $order['kiosk']['kiosk_name'] = $cart->kiosk->kiosk_name;
                $order['kiosk']['kiosk_logo'] = $cart->kiosk->kiosk_logo;
                $order['items'] = [];
                array_push($order['items'], $cart);
                array_push($carts, $order);
            }else{
                array_push($order['items'], $cart);
                foreach($carts as $key => $crt){
                    if($cart->kiosk_id === $crt['kiosk']['kiosk_id']){
                        $carts[$key] = $order;
                    }
                }
            }
        }

        $carts = collect($carts);
        
        $shipments = ShipmentMethod::all();

        $paymentMethods = PaymentMethod::all();

        return view('order', [
            'page_title' => 'Order',
            'sidebar' => true,
            'carts' => $carts,
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
       $request->validate([
            'orders' => 'required|array',
            'payment_method' => 'required',
            'address' => 'required',
            'orders.*.shipment_id' => 'required',
            'orders.*.items.*.product_id' => 'required|integer|exists:products,id',
            'orders.*.items.*.order_qty' => 'required|integer',
       ], [
            'orders.*.shipment_id.required' => 'shipment method for all orders are required',
            'payment_method.required' => 'please select payment method' 
       ]);

       foreach($request->orders as $order){
            $insertedOrder = Order::create([
                'user_id' => Auth::user()->id,
                'kiosk_id' => $order['kiosk_id'],
                'address' => $request->address,
                'total_price' => $order['totalPerOrder'],
                'payment_id' => $request->payment_method,
                'shipment_id' => $order['shipment_id'],
            ]);

            foreach($order['items'] as $item){
                OrderItem::create([
                    'order_id' => $insertedOrder->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['order_qty']
                ]);
                Cart::destroy($item['cart_id']);
            }
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
