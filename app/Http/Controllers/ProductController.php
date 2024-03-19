<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->product_name){
            $products = Product::where('product_name', 'LIKE', $request->product_name)
                                ->where('kiosk_id', Auth::user()->kiosk->id)
                                ->paginate(10);
        }else{
            $products = Product::where('kiosk_id', Auth::user()->kiosk->id)->paginate(10);
        }

        return view('seller.product.index',[
            'page_title' => 'Products',
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.product.create', [
            'page_title' => 'Add Product',
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        if($request->file('product_picture')){
            $validatedData['product_picture'] = $request->file('product_picture')->store('product-picture', 'public');
        }else{
            $validatedData['product_picture'] = 'product-picture/default.jpg';
        }
        $validatedData['kiosk_id'] = Auth::user()->kiosk->id;
        Product::create($validatedData);
        return redirect(route('product.index'))->with('success', 'New product has been save!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('seller.product.detail', [
            'page_title' => 'Product Detail',
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $units = ['pcs', 'kg', 'box', 'pack', 'sak'];
        return view('seller.product.edit', [
            'page_title' => 'Edit Product',
            'product' => $product,
            'categories' => Category::all(),
            'units' => $units
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        if($request->file('product_picture')){
            if($request->old_image){
                Storage::disk('public')->delete($product->product_picture);
            }
            $validatedData['product_picture'] = $request->file('product_picture')->store('product-picture', 'public');
        }

        Product::where('id', $product->id)
                    ->update($validatedData);
        return redirect(route('product.index'))->with('success', 'Product '. $product->product_name .' has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->kiosk_id !== Auth::user()->kiosk->id){
            return abort(404);
        }

        if($product->product_picture AND $product->product_picture !== 'product-picture/default.jpg'){
            Storage::disk('public')->delete($product->product_picture);
        }

        Product::destroy($product->id);        

        return redirect('/product')->with('success', 'product '. $product->name .' successfully deleted');
    }
}
