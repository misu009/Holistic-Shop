<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Collaborator;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::paginate(15);
        return view('admin.services.index', compact('services'));
    }
    public function create()
    {
        $collaborators = Collaborator::all();
        return view('admin.services.create', compact('collaborators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'required|string',
            'picture' => 'required|mimes:jpeg,png,jpg,gifjpeg,png,jpg|max:40480',
            'price' => 'decimal:0,2|required',
            'primary_collaborators' => 'required|array',
            'disabled' => 'boolean',
            'primary_collaborators.*' => 'required|exists:collaborators,id',
            'secondary_collaborators' => 'nullable|array',
            'secondary_collaborators.*' => 'nullable|exists:collaborators,id',
        ]);

        $service = $request->only('name', 'description', 'price', 'disabled');

        if ($request->has('picture')) {
            $path = $request->file('picture')->store('services', 'public');
            $service['picture'] = $path;
        }
        $service = Services::create($service);

        ActivityLogger::log('Added a new service', 'Services', $service->id);

        foreach ($request->primary_collaborators as $collaboratorId) {
            $service->collaborators()->attach($collaboratorId, ['is_primary' => true]);
        }

        if ($request->has('secondary_collaborators')) {
            foreach ($request->secondary_collaborators as $collaboratorId) {
                $service->collaborators()->attach($collaboratorId, ['is_primary' => false]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Services $service)
    {
        $collaborators = Collaborator::all();
        return view('admin.services.edit', compact('service', 'collaborators'));
    }

    public function update(Request $request, Services $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('services', 'name')->ignore($service->id)],
            'description' => 'required|string',
            'image' => 'mimes:jpeg,png,jpg,png,jpg|max:40480',
            'price' => 'decimal:0,2|required',
            'disabled' => 'boolean',
            'primary_collaborators' => 'required|array',
            'primary_collaborators.*' => 'required|exists:collaborators,id',
            'secondary_collaborators' => 'nullable|array',
            'secondary_collaborators.*' => 'nullable|exists:collaborators,id',
        ]);

        $service->collaborators()->detach();
        foreach ($request->primary_collaborators as $collaboratorId) {
            $service->collaborators()->attach($collaboratorId, ['is_primary' => true]);
        }

        if ($request->has('secondary_collaborators')) {
            foreach ($request->secondary_collaborators as $collaboratorId) {
                $service->collaborators()->attach($collaboratorId, ['is_primary' => false]);
            }
        }
        if ($request->hasFile('image')) {
            if ($service->picture && Storage::exists('public/' . $service->picture)) {
                Storage::delete('public/' . $service->picture);
            }
            $path = $request->file('image')->store('services', 'public');
            $service->picture = $path;
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'disabled' => $request->has('disabled') ? 1 : 0,
            'price' => $request->price,
        ]);
        ActivityLogger::log('Updated an service', 'Service', $service->id);

        return redirect()->route('admin.services.edit', $service->id)->with('success', 'Service updated successfully.');
    }


    public function destroy(Services $service)
    {
        if (Storage::exists('public/' . $service->picture)) {
            Storage::delete('public/' . $service->picture);
        }
        $service->collaborators()->detach();

        $service->delete();

        ActivityLogger::log('Deleted a service', 'Services', $service->id);

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}