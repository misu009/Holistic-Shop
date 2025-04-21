<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_text_1',
        'hero_text_2',
        'hero_text_3',
        'shop_text_1',
        'shop_text_2',
        'shop_text_3',
        'event_text_1',
        'shop_img_1',
        'shop_img_2',
        'shop_img_3',
        'shop_img_4',
        'event_img',
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