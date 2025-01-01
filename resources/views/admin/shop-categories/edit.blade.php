@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
    <div class="content p-lg-5 ml-5">
        <x-alert-notification />
        <form action="{{ route('admin.shop-categories.update', ['productCategory' => $productCategory->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Category Name"
                attributes-param='type=text id=name required'
                value="{!! old('name') ? old('name') : $productCategory->name !!}" 
                name="name" />
            <div>
                <label for="description">Category description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{{ old('description') ? old('description') : $productCategory->description }}</textarea>
            </div>
            <br>

            <!-- Image preview -->
            <img id="image-preview" src="{{ Storage::url($productCategory->picture) }}">

            <!-- Hidden file input -->
            <input type="file" id="select-picture" name="picture" accept="image/*">
            <button type="button" class="btn btn-warning"
                onclick="uploadImageCanvas('select-picture', 'image-preview', 'image-form')">upload image</button>
            <br><br>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Save User</button>
            </div>


        </form>
    </div>
@endsection
