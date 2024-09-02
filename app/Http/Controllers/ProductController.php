<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Order_Products;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function storeProduct(Request $request){
        $request->validate([
            'image' => ['required', 'image'],
            'name' => ['required', 'string', 'max:80', 'min:5'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'categoryId' => ['required', 'exists:categories,id'],
        ]);

        $file = $request->file('image');
        $filename = Str::uuid().'_'.$file->getClientOriginalName();
        $file->storeAs('/public'.'/'.$filename);

        $product = Product::create([
            'image' => $filename,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'categoryId' => $request->categoryId,
        ]);
        
        return redirect()->back()->with('message', 'Product created successfully');
    }

    public function deleteProduct($id){
        if(Auth::user()->role == 'Admin'){
            $product = Product::find($id);
            if(!$product){
                return redirect('/dashboard')->with('error', 'Product not found');
            }
            if(Order_Products::where('productId', $product->id)->first()){
                $product->is_hidden = 1;
                $product->save();
                if(Cart::where('productId', $product->id)){
                    Cart::where('productId', $product->id)->delete();
                }
                return redirect()->back()->with('error', 'Product only hidden, because it is still in the order');
            }
            if(Product::where('image', $product->image)->count() == 1){
                Storage::delete('/public'.'/'.$product->image);
            }
            $product->delete();
            return redirect()->back()->with('message', 'Product deleted successfully');
        }
        else{
            return redirect('/dashboard');
        }
    }

    public function editProduct(Request $request, $id){
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('admin.dashboard')->with('error', 'Product not found');
        }

        if($product->is_purchased){
            $request->validate([
                'image' => ['sometimes', 'image'],
                'name' => ['required', 'string', 'max:80', 'min:5'],
                'price' => ['required', 'numeric', 'min:1'],
                'stock' => ['required', 'numeric', 'min:1'],
                'categoryId' => ['sometimes', 'exists:categories,id'],
            ]);
            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = Str::uuid().'_'.$file->getClientOriginalName();
                $file->storeAs('/public'.'/'.$filename);
            }
            else{
                $filename = $product->image;
            }

            if($request->categoryId){
                $categoryId = $request->categoryId;
            }
            else{
                $categoryId = $product->categoryId;
            }

            $newProduct = Product::create([
                'image' => $filename,
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'categoryId' => $categoryId,
            ]);
            $product->is_hidden = true;
            $product->save();
            return redirect()->route('admin.dashboard')->with('message', 'Product already purchased by someone, new product created and old product hidden!');
        }
        $request->validate([
            'image' => ['sometimes', 'image'],
            'name' => ['required', 'string', 'max:80', 'min:5'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'categoryId' => ['sometimes', 'exists:categories,id'],
        ]);

        if($request->categoryId){
            $categoryId = $request->categoryId;
        }
        else{
            $categoryId = $product->categoryId;
        }

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid().'_'.$file->getClientOriginalName();
            $file->storeAs('/public'.'/'.$filename);
            $product = Product::find($id);
            Storage::delete('/public'.'/'.$product->image);
            $product->image = $filename;
            $product->save();
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'categoryId' => $categoryId,
        ]);

        $product->save();
        
        return redirect()->back()->with('message', 'Product updated successfully');
    }

    public function unhideProduct($id){
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('admin.dashboard')->with('error', 'Product not found');
        }
        $product->is_hidden = false;
        $product->save();
        return redirect()->back()->with('message', 'Product unhidden successfully');
    }
}
