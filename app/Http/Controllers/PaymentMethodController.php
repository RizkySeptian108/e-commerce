<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payment.index', [
            'page_title' => 'Payment Method',
            'PaymentMethods' => PaymentMethod::all() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|min:3|max:50'
        ]);

        PaymentMethod::create($validatedData);

        return redirect('payment-method')->with('success', 'new payment method has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string|min:3|max:50'
        ]);

        PaymentMethod::where('id', $paymentMethod->id)
                        ->update($validatedData);

        return redirect('payment-method')->with('success', 'payment method ' . $paymentMethod->payment_method . ' is successfully change to ' . $request->payment_method);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        PaymentMethod::destroy($paymentMethod->id);

        return redirect('payment-method')->with('success', 'payment method ' . $paymentMethod->payment_method . 'is successfully deleted');
    }
}
