<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function storeCategory(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:80', 'min:5'],
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return redirect('/dashboard')->with('message', 'Category created successfully');
    }
}
