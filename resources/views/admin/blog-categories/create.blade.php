@extends('admin.layout')

@section('title', 'Add Blog Categories')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Add a new Blog Category</h2>
        <x-alert-notification />
        <form action="{{ route('admin.blog-categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Category Name" attributes-param="type=text id=name required" name="name" />
            <x-admin.input label-name="Category Slug" attributes-param="type=text id=slug required" name="slug" />
            <div>
                <label for="description">Category description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor"></textarea>
            </div>
            <br>
            <img id="image-preview">
            <input type="file" id="select-picture" name="picture" accept="image/*">
            <button type="button" class="btn btn-warning"
                onclick="uploadImageCanvas('select-picture', 'image-preview', 'image-form')">upload image</button>
            <br><br>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
        </form>
    </div>
@endsection

<style>
</style>
