@extends('admin.layout')

@section('title', 'Edit Post')

@section('content')
    <div class="content p-lg-5 ml-5">
        <x-alert-notification />
        <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Post Title" attributes-param="type=text id=title required"
                value="{!! old('title') ? old('title') : $post->title !!}" name="title" />
            <x-admin.input label-name="Post Slug(optional)" attributes-param="type=text id=slug"
                value="{!! old('slug') ? old('slug') : $post->slug !!}" name="slug" />

            <div>
                <label for="post_category">Post Categories</label>
                <select class="form-control select2" name="post_category[]" id="post_category" multiple="multiple" required>
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (
                            (old('post_category') && in_array($category->id, old('post_category'))) ||
                                (!old('post_category') && in_array($category->id, $post->categories->pluck('id')->toArray()))) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="excerpt">Excerpt</label>
                <textarea name="excerpt" id="excerpt" rows="4" class="form-textarea ckeditor">{!! old('excerpt') ? old('excerpt') : $post->excerpt !!}</textarea>
            </div>
            <br>
            <div>
                <label for="description">Post content</label>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor-media">{!! old('description') ? old('description') : $post->description !!}</textarea>
            </div>
            <br>

            <div>
                <label for="media">Add new media for post</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>

            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Save Post</button>
            </div>
        </form>
        <br>
        <x-admin.media-content :objectId="$post->id" :media="$post->media" route="admin.posts.image." objectName="postId" />
    </div>
@endsection
