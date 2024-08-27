<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

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
            Storage::delete('/public'.'/'.$product->image);
            $product->delete();
            return redirect()->back()->with('message', 'Product deleted successfully');
        }
        else{
            return redirect('/dashboard');
        }
    }
}
