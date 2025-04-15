@extends('admin.layout')

@section('title', 'Add Products')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Add a new Product</h2>
        <x-alert-notification />
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Name" attributes-param="type=text id=name required" name="name" />
            <x-admin.input label-name="Slug" attributes-param="type=text id=slug required" name="slug" />
            <div>
                <label for="product_category">Product Category</label>
                <select class="form-control select2" name="product_category[]" id="product_category" multiple="multiple"
                    required>
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('product_category') && in_array($category->id, old('product_category'))) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.input label-name="Price"
                attributes-param="type=number id=price required step=0.01 min=0 max=10000000000" name="price" />
            <div>
                <label for="description">Product description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{!! old('description') !!}</textarea>
            </div>
            <br>
            <div>
                <label for="media">Add media for product</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
@endsection
