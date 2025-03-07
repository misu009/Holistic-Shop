<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $blogPosts = Post::latest()->get();
        $products = Product::latest()->get();
        return view('admin.settings.index', compact('settings', 'blogPosts', 'products'));
    }

    public function update(Request $request)
    {
        // dd($request);
        $request->validate([
            'mission_text' => 'required|string',
            'mission_bullets' => 'required|array|min:8|max:8',
            'about_text' => 'required|string',
            'selected_blog_posts' => 'required|array|min:3|max:3',
            'selected_products' => 'required|array|min:4|max:4',
        ]);

        // Process navbar links (Ensure correct format)
        // $navbarLinks = array_values(array_filter($request->navbar_links, function ($link) {
        //     return isset($link['name'], $link['url']);
        // }));

        $settings = Setting::first() ?? new Setting();
        $settings->fill([
            'mission_text' => $request->mission_text,
            'mission_bullets' => $request->mission_bullets,
            'about_text' => $request->about_text,
            'selected_blog_posts' => $request->selected_blog_posts,
            'selected_products' => $request->selected_products,
        ]);
        $settings->save();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}