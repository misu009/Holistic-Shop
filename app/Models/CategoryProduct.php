<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_products';

    protected $fillable = [
        'product_id',
        'product_category_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_products')
            ->using(CategoryProduct::class)
            ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products')
            ->using(CategoryProduct::class)
            ->withTimestamps();
    }
}