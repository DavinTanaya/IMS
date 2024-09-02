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
        'provinceId',
        'cityId',
        'zip_code',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function order_products()
    {
        return $this->hasMany(Order_Products::class, 'orderId');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinceId');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId');
    }
}
