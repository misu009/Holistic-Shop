@extends('admin.layout')

@section('title', 'Editeaza Categorie')

@section('content')
    <div class="content p-lg-5 ml-5">
        <x-alert-notification />
        <form action="{{ route('admin.blog-categories.update', ['postCategory' => $postCategory->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Nume Categorie" attributes-param='type=text id=name required'
                value="{{ old('name') ? old('name') : $postCategory->name }}" name="name" />
            <x-admin.input label-name="Slug Categorie" attributes-param='type=text id=slug required'
                value="{{ old('slug') ? old('slug') : $postCategory->slug }}" name="slug" />

            <div>
                <label for="description">Descrierea Categoriei</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{{ old('description') ? old('description') : $postCategory->description }}</textarea>
            </div>


            <br>
            <!-- Image preview -->
            <img id="image-preview" src="{{ Storage::url($postCategory->picture) }}">

            <!-- Hidden file input -->
            <input type="file" id="select-picture" name="picture" accept="image/*">
            <button type="button" class="btn btn-warning"
                onclick="uploadImageCanvas('select-picture', 'image-preview', 'image-form')">upload image</button>
            <br><br>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Actualizeaza Categorie</button>
            </div>


        </form>
    </div>
@endsection
