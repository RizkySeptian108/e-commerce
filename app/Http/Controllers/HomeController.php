<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $kioskId = '';
        if (Auth::check()) { // Check if there is an authenticated user
            $user = Auth::user();
            if ($user->kiosk) { // Check if the user has a kiosk associated
                $kioskId = $user->kiosk->id;
            }
        }
        return view('home', [
            'page_title' => 'Home',
            'sidebar' => true,
            'categories' => Category::all(),
            'products' => Product::latest()->filter(request(['search', 'category', 'kiosk']))->where('kiosk_id', '!=', $kioskId)->paginate(12),
            'searchs' => request(['search', 'category', 'kiosk']) 
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
