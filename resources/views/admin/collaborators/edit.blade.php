@extends('admin.layout')

@section('title', 'Update Collaborator')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Update collaborator</h2>
        <x-alert-notification />
        <form action="{{ route('admin.collaborators.update', ['collaborator' => $collaborator->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Collaborator Name" attributes-param="type=text id=name required"
                value="{{ old('name') ? old('name') : $collaborator->name }}" name="name" />
            <div>
                <label for="description">Category short description</label>
                <br>
                <textarea name="short_description" id="short_description" rows="4" class="form-textarea ckeditor">{{ old('short_description') ? old('short_description') : $collaborator->short_description }}</textarea>
            </div>
            <br>
            <div>
                <label for="description">Category description</label>
                <br>
                <textarea name="long_description" id="long_description" rows="4" class="form-textarea ckeditor">{{ old('long_description') ? old('long_description') : $collaborator->long_description }}</textarea>
            </div>
            <br>
            <x-admin.input label-name="Collaborator Email <small class='text-danger'>(optional)</small>"
                attributes-param="type=text id=email" value="{{ old('email') ? old('email') : $collaborator->email }}"
                name="email" />
            <x-admin.input label-name="Collaborator Phone Number <small class='text-danger'>(optional)</small>"
                attributes-param="type=tel id=phone_number"
                value="{{ old('phone_number') ? old('phone_number') : $collaborator->phone_number }}" name="phone_number" />
            <br>
            <img id="image-preview" src="{{ Storage::url($collaborator->picture) }}">
            <input type="file" id="select-picture" name="picture" accept="image/*">
            <button type="button" class="btn btn-warning"
                onclick="uploadImageCanvas('select-picture', 'image-preview', 'image-form')">upload image</button>
            <br><br>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary" style="">Update Collaborator</button>
            </div>
        </form>
    </div>
@endsection
