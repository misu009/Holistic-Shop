<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientPostController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $posts = Post::orderBy('order')->paginate(12);
        return view('client.posts.index', compact('posts', 'settings'));
    }

    public function show($slug)
    {
        $settings = Setting::first() ?? new Setting();
        $allPosts = Post::orderBy('order')->get();

        $post = Post::where('slug', $slug)->firstOrFail();
        $currentIndex = $allPosts->search(fn($p) => $p->id === $post->id);
        $prevPost = $allPosts[($currentIndex - 1 + $allPosts->count()) % $allPosts->count()];
        $nextPost = $allPosts[($currentIndex + 1) % $allPosts->count()];
        return view('client.posts.show', compact('post', 'settings', 'prevPost', 'nextPost'));
    }
}
