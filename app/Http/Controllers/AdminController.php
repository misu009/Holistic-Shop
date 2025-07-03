<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Collaborator;
use App\Models\Events;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use \App\Models\Visit;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        // dd(Session::all());
        $totalVisits = Visit::visitsLast30DaysUntilNoon();
        $postCount = Post::all()->count();
        $userCount = User::all()->count();
        $productCount = Product::all()->count();
        $collaborators = Collaborator::latest()->take(3)->get();
        $posts = Post::latest()->take(3)->get();
        $events = Events::latest()->take(3)->get();
        $logs = ActivityLog::latest()->take(5)->get();
        return view('admin.home', compact('postCount', 'userCount', 'productCount', 'collaborators', 'posts', 'events', 'logs', 'totalVisits'));
    }
}
