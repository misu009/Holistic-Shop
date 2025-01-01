<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'picture',
        'description',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_posts', 'post_category_id', 'post_id');
    }
}
