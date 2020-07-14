<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price'];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function image()
    {
        return $this->belongsTo(ProductImage::class, 'products_images');
    }
}
