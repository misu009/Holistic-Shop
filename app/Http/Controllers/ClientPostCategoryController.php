<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientPostCategoryController extends Controller
{
    public function show(PostCategory $category)
    {
        $settings = Setting::first() ?? new Setting();
        $posts = $category->posts()->orderBy('order')->paginate(12);
        return view('client.posts.index', compact('posts', 'settings', 'category'), [
            'heading' => 'Articolele din categoria ' . $category->name,
        ]);
    }
}
