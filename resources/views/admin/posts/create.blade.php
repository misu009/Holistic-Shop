@extends('admin.layout')

@section('title', 'Adauga postare')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Adauga postare</h2>
        <x-alert-notification />
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Titlu postare" attributes-param="type=text id=title required" name="title"
                value="{{ old('title') }}" />
            <x-admin.input label-name="Slug postare (optional)" attributes-param="type=text id=slug" name="slug"
                value="{{ old('slug') }}" />
            <div>
                <label for="post_category">Categorii postari</label>
                <select class="form-control select2" name="post_category[]" id="post_category" multiple="multiple" required>
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('post_category') && in_array($category->id, old('post_category'))) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="excerpt">Scurta descriere (optional)</label>
                <textarea name="excerpt" id="excerpt" rows="4" class="form-textarea ckeditor">{!! old('excerpt') !!}</textarea>
            </div>
            <br>
            <div>
                <label for="description">Descriere</label>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor-media">{!! old('description') !!}</textarea>
            </div>
            <br>
            <x-admin.input label-name="Pozitie postare (default 99999)" attributes-param="type=text id=order" name="order"
                value="{{ old('order') }}" />
            <div>
                <label for="preview_image">Adauga imagine preview</label>
                <br>
                <x-admin.image-uploader imagePreviewId="preview_image" path="" imageInputId="select-picture"
                    imageInputName="preview_image" buttonText="Upload Image" />
            </div>
            <br><br>

            <div>
                <label for="media">Adauga media pentru postare</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>

            <button type="submit" name="action" value="save" class="btn btn-primary">Adauga postarea</button>
            <button type="submit" name="action" value="preview" class="btn btn-warning">Preview</button>
        </form>
    </div>
@endsection
