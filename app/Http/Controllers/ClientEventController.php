<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientEventController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? null;
        $events = Events::where('disabled', 0)->orderBy('ends_at', 'desc')->get();
        $events->transform(function ($event) {
            $event->starts_at = date('d.m.Y', strtotime($event->starts_at));
            return $event;
        });
        return view('client.events.index', compact('events', 'settings'));
    }
}