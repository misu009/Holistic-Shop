<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Http\Request;

class ClientColloboratorController extends Controller
{
    public function index()
    {
        $paginatedCollaborators = Collaborator::paginate(12);
        $collaborators = Collaborator::all();
        return view('client.collaborators.index', compact('collaborators', 'paginatedCollaborators'));
    }
}
