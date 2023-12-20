<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.index', [
            'page_title' => 'Categories',
            'categories' => Category::all() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|min:3|max:50'
        ]);

        Category::create($validatedData);

        return redirect('category')->with('success', 'new category successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|min:3|max:50'
        ]);

        Category::where('id', $category->id)
                        ->update($validatedData);

        return redirect('category')->with('success', 'category ' . $category->category_name . ' is successfully change to ' . $request->category_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        Category::destroy($category->id);

        return redirect('category')->with('success', 'category ' . $category->category_name . 'is successfully deleted');
    }
}
