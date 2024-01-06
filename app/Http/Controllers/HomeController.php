<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if($request->category){
            
        }

        return view('home', [
            'page_title' => 'Home',
            'sidebar' => true,
            'products' => Product::paginate(18)
        ]);       
    }
}
