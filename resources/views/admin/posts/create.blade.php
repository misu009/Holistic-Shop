@extends('admin.layout')

@section('title', 'Add Post')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Add a new Post</h2>
        <x-alert-notification />
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Post title" attributes-param="type=text id=title required" name="title"
                value="{{ old('title') }}" />
            <x-admin.input label-name="Post slug (optional)" attributes-param="type=text id=slug" name="slug"
                value="{{ old('slug') }}" />
            <div>
                <label for="post_category">Post Categories</label>
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
                <label for="excerpt">Excerpt (optional)</label>
                <textarea name="excerpt" id="excerpt" rows="4" class="form-textarea ckeditor">{!! old('excerpt') !!}</textarea>
            </div>
            <br>
            <div>
                <label for="description">Post description</label>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor-media">{!! old('description') !!}</textarea>
            </div>
            <br>
            <div>
                <label for="media">Add media for post</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            
            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>
@endsection
