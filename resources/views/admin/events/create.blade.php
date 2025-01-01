@extends('admin.layout')

@section('title', 'Add Event')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Add a new Event</h2>
        <x-alert-notification />
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Event Name" attributes-param="type=text id=name required" value="{{ old('name') }}"
                name="name" />
            <div>
                <label for="description">Description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{{ old('description') }}</textarea>
            </div>
            <br>

            <div>
                <label for="primary_collaborators">Primary Collaborators</label>
                <select class="form-control select2" multiple="multiple" name="primary_collaborators[]"
                    id="primary_collaborators" required>
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (old('primary_collaborators') && in_array($collaborator->id, old('primary_collaborators'))) selected @endif>
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
                        <option value="{{ $collaborator->id }}" @if (old('secondary_collaborators') && in_array($collaborator->id, old('secondary_collaborators'))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-admin.input label-name="Event Start Date" attributes-param="type=date id=starts_at required"
                value="{{ old('starts_at') }}" name="starts_at" />
            <x-admin.input label-name="Event End Date" attributes-param="type=date id=ends_at required"
                value="{{ old('ends_at') }}" name="ends_at" />
            <x-admin.input label-name="Price"
                attributes-param="type=number id=price required step=0.01 min=0 max=10000000000" name="price" />
            <div>
                <label for="media">Add media for product</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
    </div>
@endsection
