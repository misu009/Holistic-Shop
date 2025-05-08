<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientEventController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $events = Events::where('disabled', 0)->orderBy('ends_at', 'desc')->paginate(10);
        $events->transform(function ($event) {
            $event->starts_at = date('d.m.Y', strtotime($event->starts_at));
            return $event;
        });
        return view('client.events.index', compact('events', 'settings'));
    }

    public function show($id)
    {
        $settings = Setting::first() ?? new Setting();
        $event = Events::findOrFail($id);
        $event->starts_at = date('d.m.Y', strtotime($event->starts_at));
        return view('client.events.show', compact('event', 'settings'));
    }
}
