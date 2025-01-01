<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table = 'category_posts';

    protected $fillable = [
        'post_id',
        'post_category_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'category_posts')
            ->using(PostCategory::class)
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_posts')
            ->using(CategoryPost::class)
            ->withTimestamps();
    }
}
