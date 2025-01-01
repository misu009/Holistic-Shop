@extends('admin.layout')

@section('title', 'Update Event')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Update Event</h2>
        <x-alert-notification />
        <form action="{{ route('admin.events.update', ['event' => $event->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Event Name" attributes-param="type=text id=name required"
                value="{{ old('name') ? old('name') : $event->name }}" name="name" />
            <div>
                <label for="description">Description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{{ old('description') ? old('description') : $event->description }}</textarea>
            </div>
            <br>

            <div>
                <label for="primary_collaborators">Primary Collaborators</label>
                <select class="form-control select2" multiple="multiple" name="primary_collaborators[]"
                    id="primary_collaborators" required>
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (
                            (old('primary_collaborators') && in_array($collaborator->id, old('primary_collaborators'))) ||
                                (!old('primary_collaborators') &&
                                    in_array($collaborator->id, $event->primaryCollaborators->pluck('id')->toArray()))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="secondary_collaborator">Secondary Collaborators</label> <span
                    class="text-danger">(optional)</span>
                <select class="form-control select2" multiple="multiple" name="secondary_collaborators[]"
                    id="secondary_collaborator">
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (
                            (old('secondary_collaborators') && in_array($collaborator->id, old('secondary_collaborators'))) ||
                                (!old('secondary_collaborators') &&
                                    in_array($collaborator->id, $event->nonPrimaryCollaborators->pluck('id')->toArray()))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.input label-name="Event Start Date" attributes-param="type=date id=starts_at required"
                value="{{ old('starts_at') ? old('starts_at') : \Carbon\Carbon::parse($event->starts_at)->format('Y-m-d') }}"
                name="starts_at" />
            <x-admin.input label-name="Event End Date" attributes-param="type=date id=ends_at required"
                value="{{ old('ends_at') ? old('ends_at') : \Carbon\Carbon::parse($event->ends_at)->format('Y-m-d') }}"
                name="ends_at" />
            <x-admin.input label-name="Price" value="{{ old('price', $event->price) }}"
                attributes-param="type=number id=price required step=0.01 min=0 max=10000000000" name="price" />
            <div>
                <label for="media">Add media for event</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
        <br>
        <x-admin.media-content :objectId="$event->id" :media="$event->media" route="admin.event.image." objectName="eventId" />
    </div>
@endsection
