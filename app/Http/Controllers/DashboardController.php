<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        if(Auth::check()){
            $products = Product::all();
            $categories = Category::where('is_active', 1)->get();
            if(Auth::user()->role == 'Admin'){
                if(request()->query('id')){
                    $product = Product::find(request()->query('id'));
                }
                return view('admin.dashboard', [
                    "products" => $products,
                    "categories" => $categories,
                    "productForm" => $product ?? null,
                ]);
            }else{
                // $carts = Cart::where('user_id', auth()->id())->with('item')->get();
                return view('user.dashboard', [
                    "products" => $products,
                    // "carts" => $carts,
                    "categories" => $categories,
                ]);
            }
        }
    }
}
