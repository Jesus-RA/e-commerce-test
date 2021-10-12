<?php

namespace App\Models;

use Database\Factories\Order\OrderFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'state',
        'country'
    ];

    public static function newFactory()
    {
        return OrderFactory::new();
    }

    public function products()
    {
        // return $this->belongsToMany(Product::class, 'order_product');
        return $this->belongsToMany(Product::class, 'order_product');
    }
}
