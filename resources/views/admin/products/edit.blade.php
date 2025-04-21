@extends('admin.layout')

@section('title', 'Update Product')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Update a Product</h2>
        <x-alert-notification />
        <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Name" attributes-param='type=text id=name required' value="{!! old('name') ? old('name') : $product->name !!}"
                name="name" />
            <x-admin.input label-name="Slug (optional)" attributes-param='type=text id=slug' value="{!! old('slug') ? old('slug') : $product->slug !!}"
                name="slug" />
            <div>
                <label for="product_category">Product Category</label>
                <select class="form-control select2" name="product_category[]" id="product_category" multiple="multiple"
                    required>
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (
                            (old('product_category') && in_array($category->id, old('product_category'))) ||
                                (!old('product_category') && in_array($category->id, $product->categories->pluck('id')->toArray()))) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.input label-name="Price"
                attributes-param="value={{ old('price') ? old('price') : $product->price }} type=number id=price required step=0.01 min=0 max=10000000000"
                name="price" />
            <div>
                <label for="description">Product description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{!! old('description') ? old('description') : $product->description !!}</textarea>
            </div>
            <br>
            <div>
                <label for="media">Add new media for product</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
        <br>
        <x-admin.media-content :objectId="$product->id" :media="$product->media" route="admin.product.image." objectName="productId" />
    </div>
@endsection
