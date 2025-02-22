<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'driver_id',
        'total_price',
        'shipping_cost',
        'total_bill',
        'payment_method',
        'status',
        'shipping_address',
        'shipping_latlong',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
