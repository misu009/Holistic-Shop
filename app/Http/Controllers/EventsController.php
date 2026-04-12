<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Collaborator;
use App\Models\Events;
use App\Traits\admin\MediaContentTrait;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:events,name',
            'description' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:40480',
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

        // Optimized Pivot Syncing
        $pivotData = [];
        foreach ($request->primary_collaborators as $id) {
            $pivotData[$id] = ['is_primary' => true];
        }
        if ($request->secondary_collaborators) {
            foreach ($request->secondary_collaborators as $id) {
                $pivotData[$id] = ['is_primary' => false];
            }
        }
        $event->collaborators()->sync($pivotData);

        // Intervention v3 Optimization
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $filename = 'events/' . uniqid('event_') . '.webp';

            $img = $manager->read($request->file('image'));
            $encoded = $img->scaleDown(width: 1000)->toWebp(quality: 80);

            Storage::disk('public')->put($filename, $encoded->toString());

            $event->media()->create([
                'path' => $filename,
                'order' => 1,
            ]);
        }

        ActivityLogger::log('Added a new event', 'Event', $event->id);
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function update(Request $request, Events $event)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('events', 'name')->ignore($event->id)],
            'description' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:40480',
            'price' => 'decimal:0,2|required',
            'primary_collaborators' => 'required|array',
            'primary_collaborators.*' => 'required|exists:collaborators,id',
            'secondary_collaborators' => 'nullable|array',
            'secondary_collaborators.*' => 'nullable|exists:collaborators,id',
        ]);

        // Optimized Pivot Syncing
        $pivotData = [];
        foreach ($request->primary_collaborators as $id) {
            $pivotData[$id] = ['is_primary' => true];
        }
        if ($request->secondary_collaborators) {
            foreach ($request->secondary_collaborators as $id) {
                $pivotData[$id] = ['is_primary' => false];
            }
        }
        $event->collaborators()->sync($pivotData);

        if ($request->hasFile('image')) {
            // Delete old images associated with this event
            foreach ($event->media as $media) {
                $this->deleteImage($event->id, $media->id, Events::class);
            }

            $manager = new ImageManager(new Driver());
            $filename = 'events/' . uniqid('event_') . '.webp';

            $img = $manager->read($request->file('image'));
            $encoded = $img->scaleDown(width: 1920)->toWebp(quality: 80);
            Storage::disk('public')->put($filename, $encoded->toString());

            $event->media()->create([
                'path' => $filename,
                'order' => 1,
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

    public function edit(Events $event)
    {
        $collaborators = Collaborator::all();
        return view('admin.events.edit', compact('event', 'collaborators'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Events $event)
    {
        $event->collaborators()->detach();
        foreach ($event->media as $media) {
            if (Storage::exists('public/' . $media->path)) {
                Storage::delete('public/' . $media->path);
            }
        }
        $event->delete();
        ActivityLogger::log('Deleted an event', 'Event', $event->id);
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
