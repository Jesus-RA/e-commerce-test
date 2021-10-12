<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Product\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'status',
        'stock'
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function scopeExists($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
