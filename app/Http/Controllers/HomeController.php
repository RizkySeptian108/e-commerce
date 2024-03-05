<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'page_title' => 'Home',
            'sidebar' => true,
            'categories' => Category::all(),
            'products' => Product::latest()->filter(request(['search', 'category', 'kiosk']))->where('kiosk_id', '!=', Auth::user()->kiosk->id)->paginate(12)
        ]);       
    }

    public function product(Product $product)
    {
        return view('home-product', [
            'page_title' => $product->product_name,
            'product' => $product,
            'sidebar' => true
        ]);
    }
}
