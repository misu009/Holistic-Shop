<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientColloboratorController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $paginatedCollaborators = Collaborator::paginate(12);
        $collaborators = Collaborator::all();
        // dd($collaborators);
        return view('client.collaborators.index', compact('collaborators', 'paginatedCollaborators', 'settings'));
    }
}
