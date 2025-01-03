<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }
}