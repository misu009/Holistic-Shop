@extends('admin.layout')

@section('title', 'Actualizeaza produs')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Actualizeaza produs</h2>
        <x-alert-notification />
        <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Nume produs" attributes-param='type=text id=name required'
                value="{!! old('name') ? old('name') : $product->name !!}" name="name" />
            <x-admin.input label-name="Slug produs(optional)" attributes-param='type=text id=slug'
                value="{!! old('slug') ? old('slug') : $product->slug !!}" name="slug" />
            <div>
                <label for="product_category">Categorii produse</label>
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
            <x-admin.input label-name="Pret"
                attributes-param="value={{ old('price') ? old('price') : $product->price }} type=number id=price required step=0.01 min=0 max=10000000000"
                name="price" />
            <x-admin.input label-name="Contact tel" attributes-param="type=text id=phone required" name="phone"
                :value="old('phone') ?? $product->phone" />
            <x-admin.input label-name="Contact email (optional)" attributes-param="type=email id=email" name="email"
                :value="old('email') ?? $product->email" />
            <x-admin.input label-name="Pozitie produs (default 99999)"
                attributes-param="type=number id=order required step=1 min=0 max=10000000000" name="order"
                :value="old('order') ?? $product->order" />
            <div>
                <label for="description">Descriere produs</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{!! old('description') ? old('description') : $product->description !!}</textarea>
            </div>
            <br>
            <div>
                <label for="media">Adauga media pentru produs</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            <button type="submit" name="action" value="preview" class="btn btn-outline-warning">Preview</button>
            <button type="submit" name="action" value="save" class="btn btn-primary">Actualizeaza produs</button>
        </form>
        <br>
        <x-admin.media-content :objectId="$product->id" :media="$product->media" route="admin.product.image." objectName="productId" />
    </div>
@endsection
