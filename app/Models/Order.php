<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'total_price',
        'address',
        'zip_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function order_products()
    {
        return $this->hasMany(Order_Products::class, 'orderId');
    }
}
