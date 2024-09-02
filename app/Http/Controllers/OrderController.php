<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Order_Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function storeOrder(Request $request){
        $request->validate([
            'address' => ['required', 'string', 'min:10', 'max:100'],
            'zip_code' => ['required', 'string', 'min:5', 'max:5'],
            'city' => ['required', 'exists:cities,id'],
            'province' => ['required', 'exists:provinces,id'],
        ]);
        $carts = Cart::where('userId', auth()->id())->get() ?? abort(404);
        $total_price = $carts->sum('total');
        $order = Order::create([
            'userId' => auth()->id(),
            'total_price' => $total_price,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'cityId' => $request->city,
            'provinceId' => $request->province,
        ]);
        $order->token = hash('sha256', $order->id);
        $order->save();
        foreach ($carts as $cart){
            $order_products = Order_Products::create([
                'orderId' => $order->id,
                'productId' => $cart->productId,
                'quantity' => $cart->quantity,
                'total' => $cart->total,
            ]);
            $cart->product->is_purchased = true;
            $cart->product->save();
            $cart->delete();
        }
        return redirect('/dashboard')->with('message', 'Order success');
    }

    public function getInvoice($token){
        $order = Order::where('token', $token)->where('userId', Auth::user()->id)->first();
        if(!$order){
            return redirect('/dashboard')->with('error', 'Order not found');
        }
        $order->load('order_products', 'order_products.product', 'user');
        $order->formatted_date  = Carbon::parse($order->created_at)->translatedFormat('l\, jS F Y');
        $order->formatted_hour  = Carbon::parse($order->created_at)->translatedFormat('h:i:s A');
        $city = City::where('cityId', $order->cityId)->first();
        return view('user.invoice', [
            'order' => $order,
            'city' => $city,
        ]);
    }
}
