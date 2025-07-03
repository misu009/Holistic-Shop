@extends('admin.layout')

@section('title', 'Actualizare postare')

@section('content')
    <div class="content p-lg-5 ml-5">
        <x-alert-notification />
        <h2 class="text-center">Actualizeaza postare</h2>
        <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" id="editor-js-form" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Titlu postare" attributes-param="type=text id=title required"
                value="{!! old('title') ? old('title') : $post->title !!}" name="title" />
            <x-admin.input label-name="Slug postare(optional)" attributes-param="type=text id=slug"
                value="{!! old('slug') ? old('slug') : $post->slug !!}" name="slug" />

            <div>
                <label for="post_category">Categorii de postari</label>
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
                <label for="excerpt">Excerpt (optional)</label>
                <textarea name="excerpt" id="excerpt" rows="4" class="form-textarea ckeditor">{!! old('excerpt') ? old('excerpt') : $post->excerpt !!}</textarea>
            </div>
            <br>
            <div>
                <label for="editorjs">Descriere</label>
                <div id="editorjs" class="bg-white"></div>
                <input type="hidden" name="description" id="description" value="{!! old('description') ?? $post->description !!}">
            </div>
            <br>
            <x-admin.input label-name="Pozitie postare (optional)" attributes-param="type=text id=order"
                value="{!! old('order') ? old('order') : $post->order !!}" name="order" />
            <div>
                <label for="preview_image">Imagine preview</label>
                <br>
                <x-admin.image-uploader imagePreviewId="preview_image" path="{{ Storage::url($post->preview_image) }}"
                    imageInputId="select-picture" imageInputName="preview_image" buttonText="Upload Image" />
            </div>
            <br><br>

            <div>
                <label for="media">Adauga media pentru postare</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>

            <div class="d-flex justify-content-start">
                <button type="submit" name="action" value="save" class="btn btn-primary">Actualizeaza postarea</button>
                <button type="submit" name="action" value="preview" class="btn btn-warning ms-1">Preview</button>
            </div>
        </form>
        <br>
        <x-admin.media-content :objectId="$post->id" :media="$post->media" route="admin.posts.image." objectName="postId" />
    </div>

    <script>
        window.oldEditorData = {!! json_encode(old('description') ?? $post->description) !!};
    </script>
    
@endsection
