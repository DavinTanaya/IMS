<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function storeCategory(Request $request){
        $request->validate([
            'categoryName' => ['required', 'string', 'max:80', 'min:5'],
        ]);

        if(Category::where('name', $request->categoryName)->first()){
            $cat = Category::where('name', $request->categoryName)->first();
            $cat->is_active = 1;
            $cat->save();
        }
        else{
            $category = Category::create([
                'name' => $request->categoryName,
            ]);
        }


        return redirect()->back()->with('message', 'Category created successfully');
    }

    public function deleteCategory(Request $request){
        $categoriesToDelete = $request->categories;
        $message = 'Category deleted successfully';
        foreach($categoriesToDelete as $category){
            $category = Category::find($category);
            if(!$category){
                return redirect()->route('admin.dashboard')->with('error', 'Category not found');
            }
            if($category->products->count() > 0){
                $category->is_active = 0;
                $category->save();
                $message = 'One or More Category only hidden, because it is related to products';
            }
            else{
                $category->delete();
            }
        }
        return redirect()->back()->with('message', $message);
    }
}
