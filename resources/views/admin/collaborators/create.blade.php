@extends('admin.layout')

@section('title', 'Add Collaborator')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Add a new Collaborator</h2>
        <x-alert-notification />
        <form action="{{ route('admin.collaborators.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="user">Load a user as collaborator (or complete the data below..)</label>
                <select class="form-control select2" name="user" id="user">
                    <option value=""></option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                            data-picture="{{ $user->picture }}" @if (old('user') == $user->id) selected @endif>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.input label-name="Collaborator Name" attributes-param="type=text id=name required"
                value="{{ old('name') }}" name="name" />
            <div>
                <label for="description">Collaborator short description</label>
                <br>
                <textarea name="short_description" id="short_description" rows="4" class="form-textarea">{{ old('short_description') }}</textarea>
            </div>
            <br>
            <div>
                <label for="description">Collaborator description</label>
                <br>
                <textarea name="long_description" id="long_description" rows="4" class="form-textarea">{{ old('long_description') }}</textarea>
            </div>
            <br>
            <x-admin.input label-name="Collaborator Email <small class='text-danger'>(optional)</small>"
                attributes-param="type=text id=email" value="{{ old('email') }}" name="email" />
            <x-admin.input label-name="Collaborator Phone Number <small class='text-danger'>(optional)</small>"
                attributes-param="type=tel id=phone_number" value="{{ old('phone_number') }}" name="phone_number" />
            <br>
            <img id="image-preview" src="{{ old('user-picture') ? '/storage/' . old('user-picture') : '' }}">
            <input type="text" value="{{ old('user-picture') }}" id="user-picture" name="user-picture" hidden>
            <input type="file" id="select-picture" name="picture" accept="image/*">
            <button type="button" class="btn btn-warning"
                onclick="uploadImageCanvas('select-picture', 'image-preview', 'image-form')">upload image</button>
            <br><br>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Add Collaborator</button>
            </div>
        </form>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('#user').change(function() {
            const selectedOption = $(this).find('option:selected');
            const name = selectedOption.data('name');
            const email = selectedOption.data('email');
            const picture = selectedOption.data('picture');

            document.getElementById('name').value = name || '';
            document.getElementById('email').value = email || '';
            if (picture) {
                document.getElementById('image-preview').src = `/storage/${picture}`;
                document.getElementById('user-picture').value = picture || '';
                document.getElementById('select-picture').value = ''; // Clears the file input
            }
        });
        $('#select-picture').change(function() {
            document.getElementById('user-picture').value = '';
        });
    });
</script>
