<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'hero_text_1' => 'required|string|max:30',
            'hero_text_2' => 'required|string|max:90',
            'hero_text_3' => 'required|string|max:110',
            'shop_text_1' => 'required|string',
            'shop_text_2' => 'required|string',
            'shop_text_3' => 'required|string|max:90',
            'shop_img_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_img_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_img_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_img_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_text_1' => 'required|string',
            'event_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        foreach (['shop_img_1', 'shop_img_2', 'shop_img_3', 'shop_img_4', 'event_img'] as $key) {
            if ($request->hasFile($key)) {
                if ($settings->$key) {
                    Storage::disk('public')->delete($settings->$key);
                }

                $path = $request->file($key)->store('settings', 'public');
                $settings->$key = $path;
            }
        }

        $settings->fill([
            'hero_text_1' => $request->hero_text_1,
            'hero_text_2' => $request->hero_text_2,
            'hero_text_3' => $request->hero_text_3,
            'shop_text_1' => $request->shop_text_1,
            'shop_text_2' => $request->shop_text_2,
            'shop_text_3' => $request->shop_text_3,
            'event_text_1' => $request->event_text_1,
            'mission_text' => $request->mission_text,
            'mission_bullets' => $request->mission_bullets,
            'about_text' => $request->about_text,
            'selected_blog_posts' => $request->selected_blog_posts,
            'selected_products' => $request->selected_products,
        ]);
        $settings->save();

        ActivityLogger::log('Updated settings');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
