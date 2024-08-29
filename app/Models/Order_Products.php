<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId');
    }
}
