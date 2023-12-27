<?php

namespace App\Http\Controllers;

use App\Models\Kiosk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreKioskRequest;
use App\Http\Requests\UpdateKioskRequest;

class KioskController extends Controller
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
    public function create()
    {
        return view('seller.kiosk.index', [
            'page_title' => 'Create Kiosk',
            'sidebar' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKioskRequest $request)
    {
        $validatedData = $request->validated();
        if($request->file('kiosk_logo')){
            $validatedData['kiosk_logo'] = $request->file('kiosk_logo')->store('kiosk-logo', 'public');
        }
        $validatedData['user_id'] = Auth::user()->id;
        Kiosk::create($validatedData);
        return redirect('/dashboard')->with('success', 'Your kiosk is successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kiosk $kiosk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kiosk $kiosk)
    {
        return view('seller.kiosk.edit', [
            'page_title' => 'Kiosk Profile',
            'kiosk' => $kiosk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKioskRequest $request, Kiosk $kiosk)
    {
        $validatedData = $request->validated();
        if($request->file('kiosk_logo')){
            if($request->old_kiosk_logo){
                Storage::disk('public')->delete($kiosk->kiosk_logo);
            }
            $validatedData['kiosk_logo'] = $request->file('kiosk_logo')->store('kiosk-logo', 'public');
        }
        Kiosk::where('id',$kiosk->id )
                    ->update($validatedData);
        return redirect(route('kiosk.edit', $kiosk))->with('status', 'kiosk-profile-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kiosk $kiosk)
    {
        //
    }
}
