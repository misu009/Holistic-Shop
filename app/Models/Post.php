<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'preview_image',
        'description',
        'created_by',
        'order',
    ];

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'category_posts');
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class)->orderBy('order', 'asc');
    }
}
