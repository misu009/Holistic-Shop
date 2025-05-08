@extends('admin.layout')

@section('title', 'Actualizeaza profil')

@section('content')
    <div class="content p-lg-5 ml-5">
        <x-alert-notification />
        <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data"
            id="editUserForm">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Username" attributes-param="type=text id=editName required"
                value="{{ old('name') ? old('name') : $user->name }}" name="editName" />
            <x-admin.input label-name="Email"
                attributes-param="type=email id=editEmail value={{ old('email') ? old('email') : $user->email }} required"
                name="editEmail" />
            <x-admin.input label-name="Parola <small class='text-danger'>(parolele trebuie sa coincida)</small>"
                attributes-param="type=password id=edit_password" name="password">
                <span class="position-absolute end-0 translate-middle-y pe-3"
                    onclick="togglePasswordVisibility('edit_password')" style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>
            <x-admin.input label-name="Confirma parola" attributes-param="type=password id=edit_password_confirmation"
                name="password_confirmation">
                <span class="position-absolute end-0 translate-middle-y pe-3"
                    onclick="togglePasswordVisibility('edit_password_confirmation')"
                    style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>

            <x-admin.image-uploader imagePreviewId="image-preview" path="{{ Storage::url(Auth::user()->picture) }}"
                imageInputId="select-picture" imageInputName="picture" buttonText="Upload Image" />

            <br><br>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Actualizeaza profilul</button>
            </div>


        </form>
    </div>
@endsection

<style>
</style>
