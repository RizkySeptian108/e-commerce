<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAddressRequest;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::where('user_id', Auth::user()->id)->get();

        return view('profile.address.index', [
            'page_title' => 'address setting',
            'sidebar' => false,
            'addresses' => $addresses
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.address.create', [
            'page_title' => 'add address',
            'sidebar' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = Auth::user()->id;

        $address = Address::create($validatedData);

        if($address){
            return redirect(route('address.index'))->with('success', 'New address has been save!');
        }else{
            return redirect(route('address.index'))->with('error', 'Fail to save the new address, try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        // return $address;
        return view('profile.address.edit', [
            'page_title' => 'Edit Address',
            'sidebar' => false,
            'address' => $address
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAddressRequest $request, Address $address)
    {
        $validatedData = $request->validated();

        Address::where('id', $address->id)->update($validatedData);
        return redirect(route('address.index'))->with('success', 'Address '. $address->address_label .' has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        Address::destroy($address->id);

        return redirect('address')->with('success', 'address with the label ' . $address->address_label . ' is successfully deleted');
    }

    // change the address status
    public function status(Address $address)
    {
        if(Auth::user()->id != $address->user_id){
            return abort(404);
        }else{

            Address::toggleMain($address->id);

            return redirect('address')->with('success', 'main address change to '. $address->address_label);
        }
    }
}
