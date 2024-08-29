<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $categories = Category::where('is_active', 1)->get();
        $products = Product::all()->map(function ($product) {
            $product->formatted_price = number_format($product->price, 0, ',', '.');
            return $product;
        });
        $carts = Cart::where('userId', auth()->id())->with('product')->get();
        $carts->map(function ($cart) {
            $cart->formatted_total = number_format($cart->total, 0, ',', '.');
            return $cart;
        });
        $orders = Order::where('userId', auth()->id())->get();
        $orders->map(function ($order) {
            $order->load('order_products', 'order_products.product');
            $order->formatted_date  = Carbon::parse($order->created_at)->translatedFormat('l\, jS F Y h:i:s A');;
            return $order;
        });

        return view('user.dashboard', [
                "products" => $products,
                "carts" => $carts,
                "categories" => $categories,
                "total_price" => number_format($carts->sum('total'), 0, ',', '.'),
                "orders" => $orders,
            ]);
    }

    public function getAdminDashboard() 
    {
        $categories = Category::where('is_active', 1)->get();
        $products = Product::all()->map(function ($product) {
            $product->formatted_price = number_format($product->price, 0, ',', '.');
            return $product;
        });
        if(request()->query('id')){
            $product = Product::find(request()->query('id'));
        }
        return view('admin.dashboard', [
            "products" => $products,
            "categories" => $categories,
            "productForm" => $product ?? null,
        ]);
    }

    public function fallback()
    {
        if(Auth::user()->role == 'Admin'){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
}
