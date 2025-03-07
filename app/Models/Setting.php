<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_text',
        'mission_bullets',
        'about_text',
        'selected_blog_posts',
        'selected_products',
    ];

    protected $casts = [
        'mission_bullets' => 'array',
        'selected_blog_posts' => 'array',
        'selected_products' => 'array',
    ];
}
