<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Product\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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
