<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "slug",
        "description",
        "price",
        "email",
        "phone_number",
        'user_id',
        'order',
    ];


    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, "category_products");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order', 'asc');
    }
}
