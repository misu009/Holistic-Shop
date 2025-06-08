<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientServicesController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $services = Services::where('disabled', 0)->paginate(10);
        return view('client.services.index', compact('services', 'settings'));
    }

    public function show($id)
    {
        $service = Services::findOrFail($id);
        $settings = Setting::first() ?? new Setting();
        return view('client.services.show', compact('service', 'settings'));
    }
}
