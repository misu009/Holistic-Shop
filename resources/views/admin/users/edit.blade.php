@extends('admin.layout')

@section('title', 'Edit Profile')

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
            <x-admin.input label-name="Pasword <small class='text-danger'>(passwords must match)</small>"
                attributes-param="type=password id=edit_password" name="password">
                <span class="position-absolute end-0 translate-middle-y pe-3"
                    onclick="togglePasswordVisibility('edit_password')" style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>
            <x-admin.input label-name="Confirm pasword" attributes-param="type=password id=edit_password_confirmation"
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
                <button type="submit" class="btn btn-primary">Save User</button>
            </div>


        </form>
    </div>
@endsection

<style>
</style>
