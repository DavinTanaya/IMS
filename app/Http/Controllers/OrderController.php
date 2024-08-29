<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_Products;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function storeOrder(Request $request){
        $request->validate([
            'address' => ['required', 'string', 'min:10', 'max:100'],
            'zip_code' => ['required', 'string', 'min:5', 'max:5'],
        ]);
        $carts = Cart::where('userId', auth()->id())->get() ?? abort(404);
        $total_price = $carts->sum('total');
        $order = Order::create([
            'userId' => auth()->id(),
            'total_price' => $total_price,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
        ]);
        foreach ($carts as $cart){
            $order_products = Order_Products::create([
                'orderId' => $order->id,
                'productId' => $cart->productId,
                'quantity' => $cart->quantity,
                'total' => $cart->total,
            ]);
            $cart->delete();
        }
        return redirect('/dashboard')->with('message', 'Order success');
    }
}
