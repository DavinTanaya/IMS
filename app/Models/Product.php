<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'price',
        'stock',
        'categoryId',
        'is_hidden'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'productId');
    }

    public function order_products()
    {
        return $this->hasMany(Order_Products::class, 'productId');
    }
}
