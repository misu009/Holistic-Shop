<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        return view('client.home.index', compact('settings'));
    }
}
