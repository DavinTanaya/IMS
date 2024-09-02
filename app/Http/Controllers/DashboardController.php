<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $categories = Category::where('is_active', 1)->get();
        $products = Product::where('is_hidden', 0)->get();
        $carts = Cart::where('userId', auth()->id())->with('product')->get();
        $orders = Order::where('userId', auth()->id())->get();
        $orders->map(function ($order) {
            $order->load('order_products', 'order_products.product');
            $order->formatted_date  = Carbon::parse($order->created_at)->translatedFormat('l\, jS F Y h:i:s A');
            return $order;
        });
        $provinces = Province::all();
        $cities = City::all();
        if(request()->query('category')){
            $category = Category::where('name', request()->query('category'))->first();
            if(!$category){
                return redirect('/dashboard')->with('error', 'Category not found');
            }
            $products = Product::where('categoryId', $category->id)->where('is_hidden', 0)->get();
        }

        return view('user.dashboard', [
                "products" => $products,
                "carts" => $carts,
                "categories" => $categories,
                "total_price" => number_format($carts->sum('total'), 0, ',', '.'),
                "orders" => $orders,
                "provinces" => $provinces,
                "cities" => $cities,
                "categoryFilter" => $category ?? null,
            ]);
    }

    public function getAdminDashboard() 
    {
        $categories = Category::where('is_active', 1)->get();
        $products = Product::where('is_hidden', 0)->get();
        if(request()->query('id')){
            $product = Product::find(request()->query('id'));
        }

        $query = Product::query();

        if (request()->query('hidden') == 'true') {

        } 
        else {
            $query->where('is_hidden', 0);
        }
        if (request()->query('category')) {
            $category = Category::where('name', request()->query('category'))->first();
            if (!$category) {
                return redirect()->route('admin.dashboard')->with('error', 'Category not found');
            }
            $query->where('categoryId', $category->id);
        }

        $products = $query->get();
        return view('admin.dashboard', [
            "products" => $products,
            "categories" => $categories,
            "productForm" => $product ?? null,
            "categoryFilter" => $category ?? null,
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
