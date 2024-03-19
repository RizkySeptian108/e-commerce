<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::where('kiosk_id', Auth::user()->kiosk->id)->count();
        return view('seller.dashboard', [
            'page_title' => "Dashboard",
            'products' => $products
        ]);
    }
}
