<?php

namespace App\Http\Controllers;

use App\Models\ShipmentMethod;
use Illuminate\Http\Request;

class ShipmentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.shipment.index', [
            'page_title' => 'Shipment Method',
            'shipmentMethods' => ShipmentMethod::all() 
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
            'shipment_method' => 'required|string|min:3|max:50',
            'price' => 'required|numeric'
        ]);

        ShipmentMethod::create($validatedData);

        return redirect('shipment-method')->with('success', 'new shipment method has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShipmentMethod $shipmentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipmentMethod $shipmentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShipmentMethod $shipmentMethod)
    {
        $validatedData = $request->validate([
            'shipment_method' => 'required|string|min:3|max:50',
            'price' => 'required|numeric'
        ]);

        ShipmentMethod::where('id', $shipmentMethod->id)
                        ->update($validatedData);

        return redirect('shipment-method')->with('success', 'shipment method ' . $shipmentMethod->shipment_method . ' is successfully change to ' . $request->shipment_method); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipmentMethod $shipmentMethod)
    {
        return $shipmentMethod;
        ShipmentMethod::destroy($shipmentMethod->id);

        return redirect('shipment-method')->with('success', 'shipment method ' . $shipmentMethod->shipment_method . 'is successfully deleted');
    }
}
