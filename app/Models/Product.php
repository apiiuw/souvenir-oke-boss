<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'min_order',
        'description',
    ];

    // Relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relasi ke variants (warna)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
