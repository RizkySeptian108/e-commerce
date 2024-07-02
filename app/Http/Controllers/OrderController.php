<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kiosk;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\ShipmentMethod;
use App\Http\Requests\OrderRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('orderItems.product:id,product_name,unit,product_picture,price_per_unit', 'user:id,name')->where('kiosk_id', Auth::user()->kiosk->id)->paginate(10);
        return view('seller.order.order-kiosk',[
            'page_title' => 'order list',
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderRequest $request)
    {
        $carts = [];

        $addresses = Address::where('user_id', Auth::user()->id)->get();
        
        $cart = [
            'kiosk' => [
                'kiosk_id' => null,
                'kiosk_name' => null,
                'kiosk_logo' => null
            ],
            'items' => [],
            'shipment' => [
                'shipment_id' => '',
                'shipment_method' => 'SHIPMENT METHOD',
                'price' => 0
            ]
        ];

        $orders = $request->orders;

        foreach($orders as $order){
            $kiosk = Kiosk::find($order['kiosk_id'], ['id', 'kiosk_name', 'kiosk_logo']);
            $cart['kiosk']['kiosk_id'] = $kiosk->id;
            $cart['kiosk']['kiosk_name'] = $kiosk->kiosk_name;
            $cart['kiosk']['kiosk_logo'] = $kiosk->kiosk_logo;
            $cart['items'] = [];
            foreach($order['items'] as $item){
                $cartItem = Cart::find($item['cart_id'], ['id', 'product_id', 'kiosk_id', 'qty']);
                $cartItem->load('product:id,product_name,product_picture,price_per_unit,unit', 'kiosk:id,kiosk_logo,kiosk_name');
                $cartItem->order_qty = $item['qty'];
                array_push($cart['items'], $cartItem);
            }
            array_push($carts, $cart);
        };

        $carts = collect($carts);
        
        $shipments = ShipmentMethod::all();

        $paymentMethods = PaymentMethod::all();

        return view('order', [
            'page_title' => 'Order',
            'sidebar' => true,
            'carts' => $carts,
            'shipments' => $shipments,
            'totalItems' => $request->total,
            'paymentMethods' => $paymentMethods,
            'addresses' => $addresses
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
                Product::where('id', $item['product_id'])->decrement('qty', $item['order_qty']);
                Cart::destroy($item['cart_id']);
            }
       }
       return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        
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

        if($request->status === 'confirm'){
            Order::where('id', $order->id)
                ->update([
                    'is_confirm' => true
                ]);
        }else if($request->status === 'deliver'){
            if(!$order->is_confirm){
                return redirect(route('order.index'))->with('not_confirm', 'the order is not yet confirm');
            }
            Order::where('id', $order->id)
                ->update([
                    'is_packed' => true
                ]);
        }
        return redirect(route('order.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    
    public function list(Request $request)
    {
        $items = [];
        $orders = Order::with('orderItems.product:id,product_name,unit,product_picture')->select('id', 'user_id', 'is_confirm', 'is_packed')->where('user_id', $request->user_id)->get();

        foreach($orders as $order){
            foreach($order->orderItems as $item){
                if($order->is_confirm AND $order->is_packed){
                    $item->status = "ON DELIVERY";
                }elseif($order->is_confirm){
                    $item->status = "PACKED";
                }else if(!$order->is_confirm){
                    $item->status = "PENDING";
                }
                array_push($items, $item);
            }
        }
        
        $items = collect($items);

        return response()->json(['orders' => $items->sortBy('created_at')]);
    }

    public function listKiosk(Request $request)
    {
        // list for dashboard
        $orders = Order::filter(request(['kiosk_id', 'is_confirm']))->count();
        return response()->json(['orders' => $orders]);
    }
}
