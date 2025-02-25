<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Collaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaborators = Collaborator::paginate(15);
        return view('admin.collaborators.index', compact('collaborators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        return view('admin.collaborators.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'email' => 'nullable|email|unique:collaborators,email',
            'phone_number' => 'nullable|string|regex:/^\+?[0-9]\d{1,14}$/|unique:collaborators,phone_number',
            'user-picture' => 'nullable|string|exists:users,picture',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);
        // dd($request->has('picture'));
        if ($request->has('picture')) {
            $path = $request->file('picture')->store('collaborators', 'public');
            $validated['picture'] = $path;
        } elseif ($request->has('user-picture')) {
            $validated['picture'] = $request->input('user-picture');
        }

        $collaborator = Collaborator::create($validated);
        ActivityLogger::log('Added a new collaborator', 'Collaborator', $collaborator->id);
        return redirect()->route('admin.collaborators.index')->with('success', 'Collaborator created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Collaborator $collaborator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collaborator $collaborator)
    {
        return view('admin.collaborators.edit', compact('collaborator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collaborator $collaborator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'email' => 'nullable|email|unique:collaborators,email,' . $collaborator->id,
            'phone_number' => 'nullable|string|regex:/^\+?[0-9]\d{1,14}$/|unique:collaborators,phone_number,' . $collaborator->id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);

        if ($request->has('picture')) {
            if ($collaborator->picture) {
                $this->deleteCollaboratorImage($collaborator->picture);
            }
            $path = $request->file('picture')->store('collaborators', 'public');
            $collaborator->picture = $path;
        }

        $collaborator->update($request->only(['name', 'short_description', 'long_description', 'email', 'phone_number']));
        ActivityLogger::log('Updated a collaborator', 'Collaborator', $collaborator->id);
        return redirect()->route('admin.collaborators.edit', $collaborator->id)->with('success', 'Collaborator updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collaborator $collaborator)
    {
        $this->deleteCollaboratorImage($collaborator->picture);
        $collaborator->delete();
        ActivityLogger::log('Deleted a collaborator', 'Collaborator', $collaborator->id);
        return redirect()->route('admin.collaborators.index')->with('success', 'Collaborator deleted successfully');
    }

    public function deleteCollaboratorImage($path)
    {
        if ($path && strpos($path, 'users') === false) {
            Storage::disk('public')->delete($path);
        }
    }
}
