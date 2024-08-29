<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function storeCart(Request $request, $id){
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        $oldCart = Cart::where('productId', $id)->where('userId', auth()->id())->first();
        $product = Product::find($id);
        if(!$product){
            return redirect('/dashboard')->with('error', 'Product not found');
        }
        if($request->quantity > $product->stock){
            return redirect('/dashboard')->with('error', 'Stock not enough');
        }
        if($oldCart){
            $oldCart->load('product');
            $oldCart->quantity += $request->quantity;
            $oldCart->total += $request->quantity * $oldCart->product->price;
            $oldCart->save();
            $oldCart->product->stock -= $request->quantity;
            $oldCart->product->save();
            return redirect('/dashboard')->with('message', 'Product added to cart successfully');
        }

        $product->stock -= $request->quantity;
        $product->save();

        $cart = Cart::create([
            'productId' => $id,
            'quantity' => $request->quantity,
            'userId' => auth()->id(),
            'total' => $request->quantity * $product->price,
        ]);

        return redirect('/dashboard')->with('message', 'Product added to cart successfully');
    }

    public function updateCart(Request $request, $id){
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1']
        ]);
        $cart = Cart::find($id);
        if(!$cart){
            return redirect('/dashboard')->with('error', 'Cart not found');
        }
        $cart->load('product');
        $cart->product->stock += $cart->quantity;
        $cart->quantity = $request->quantity;
        $cart->total = $request->quantity * $cart->product->price;
        $cart->product->stock -= $request->quantity;
        $cart->product->save();
        $cart->save();

        return redirect('/dashboard')->with('message', 'Cart updated successfully');
    }

    public function deleteCart($id){
        $cart = Cart::find($id);
        if(!$cart){
            return redirect('/dashboard')->with('error', 'Cart not found');
        }
        $cart->load('product');
        $cart->product->stock += $cart->quantity;
        $cart->product->save();
        $cart->delete();
        return redirect('/dashboard')->with('message', 'Product removed from cart successfully');
    }
}
