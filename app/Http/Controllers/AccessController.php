<?php

namespace App\Http\Controllers;

use App\Models\Access;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.access.index', [
            'page_title' => 'Access',
            'access' => Access::all() 
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
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'access_type' => 'required|string|min:3|max:50'
        ]);

        Access::create($validatedData);

        return redirect('access')->with('success', 'new access type has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Access $access)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Access $access)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Access $access)
    {
        $validatedData = $request->validate([
            'access_type' => 'required|string|min:3|max:50'
        ]);

        Access::where('id', $access->id)
                        ->update($validatedData);

        return redirect('access')->with('success', 'access type ' . $access->access_type. ' is successfully change to ' . $request->access_type); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Access $access)
    {
        Access::destroy($access->id);

        return redirect('access')->with('success', 'access type ' . $access->access_type . ' is successfully deleted');
    }
}
