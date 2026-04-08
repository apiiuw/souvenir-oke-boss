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
        'stock',
        'min_order',
        'description',
    ];

    // Relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke images (diurutkan berdasarkan ID untuk thumbnail)
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('id', 'asc');
    }

    // Helper untuk mendapatkan thumbnail (gambar pertama)
    public function getThumbnailAttribute()
    {
        $firstImage = $this->images->first();
        return $firstImage ? asset('storage/' . $firstImage->image) : 'https://images.unsplash.com/photo-1513151233558-d860c5398176?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';
    }

    // Relasi ke variants (tema/jenis)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Relasi ke colors
    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }
}
