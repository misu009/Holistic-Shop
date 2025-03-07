<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ClientPostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(12);
        return view('client.posts.index', compact('posts'));
    }
}
