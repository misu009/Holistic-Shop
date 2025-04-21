<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Collaborator;
use App\Models\Events;
use App\Traits\admin\MediaContentTrait;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    use MediaContentTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Events::paginate(15);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collaborators = Collaborator::all();
        return view('admin.events.create', compact('collaborators'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:events,name',
            'description' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'media' => 'required|mimes:jpeg,png,jpg,gifjpeg,png,jpg|max:40480',
            'price' => 'decimal:0,2|required',
            'primary_collaborators' => 'required|array',
            'primary_collaborators.*' => 'required|exists:collaborators,id',
            'secondary_collaborators' => 'nullable|array',
            'secondary_collaborators.*' => 'nullable|exists:collaborators,id',
        ]);
        $event = Events::create([
            'name' => $request->name,
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'price' => $request->price,
            'disabled' => $request->has('disabled') ? 1 : 0,
        ]);
        ActivityLogger::log('Added a new event', 'Event', $event->id);

        foreach ($request->primary_collaborators as $collaboratorId) {
            $event->collaborators()->attach($collaboratorId, ['is_primary' => true]);
        }

        if ($request->has('secondary_collaborators')) {
            foreach ($request->secondary_collaborators as $collaboratorId) {
                $event->collaborators()->attach($collaboratorId, ['is_primary' => false]);
            }
        }

        if ($request->hasFile('media')) {
            $path = $request->media->store('events', 'public');
            $event->media()->create([
                'path' => $path,
                'order' => $event->media()->count() + 1,
            ]);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Events $events)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Events $event)
    {
        $collaborators = Collaborator::all();
        return view('admin.events.edit', compact('event', 'collaborators'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Events $event)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('events', 'name')->ignore($event->id)],
            'description' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'image' => 'mimes:jpeg,png,jpg,png,jpg|max:40480',
            'price' => 'decimal:0,2|required',
            'primary_collaborators' => 'required|array',
            'primary_collaborators.*' => 'required|exists:collaborators,id',
            'secondary_collaborators' => 'nullable|array',
            'secondary_collaborators.*' => 'nullable|exists:collaborators,id',
        ]);
        $event->collaborators()->detach();
        foreach ($request->primary_collaborators as $collaboratorId) {
            $event->collaborators()->attach($collaboratorId, ['is_primary' => true]);
        }

        if ($request->has('secondary_collaborators')) {
            foreach ($request->secondary_collaborators as $collaboratorId) {
                $event->collaborators()->attach($collaboratorId, ['is_primary' => false]);
            }
        }

        if ($request->hasFile('image')) {
            foreach ($event->media as $media) {
                $this->deleteImage($event->id, $media->id, Events::class);
            }
            $path = $request->file('image')->store('events', 'public');
            $event->media()->create([
                'path' => $path,
                'order' => $event->media()->count() + 1,
            ]);
        }


        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'disabled' => $request->has('disabled') ? 1 : 0,
            'price' => $request->price,
        ]);
        ActivityLogger::log('Updated an event', 'Event', $event->id);

        return redirect()->route('admin.events.edit', $event->id)->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Events $event)
    {
        foreach ($event->media as $media) {
            if (Storage::exists('public/' . $media->path)) {
                Storage::delete('public/' . $media->path);
            }
        }
        $event->delete();
        ActivityLogger::log('Deleted an event', 'Event', $event->name);
        return back()->with('success', 'Event deleted successfully');
    }

    public function destroyImage($eventId, $imageId)
    {
        $this->deleteImage($eventId, $imageId, Events::class);
        return redirect()->route('admin.events.edit', $eventId)->with('success', 'Image deleted successfully');
    }

    public function updateImage(Request $request, $eventId, $imageId)
    {
        $this->changeImageOrder($eventId, $imageId, Events::class);
        return redirect()->route('admin.events.edit', $eventId)->with('success', 'Image order updated successfully');
    }
}
