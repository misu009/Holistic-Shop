@extends('admin.layout')

@section('title', 'Adauga produs')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Adauga un produs nou</h2>
        <x-alert-notification />
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Nume produs" attributes-param="type=text id=name required" name="name" />
            <x-admin.input label-name="Slug produs (optional)" attributes-param="type=text id=slug" name="slug" />
            <div>
                <label for="product_category">Categorii produse</label>
                <select class="form-control select2" name="product_category[]" id="product_category" multiple="multiple"
                    required>
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('product_category') && in_array($category->id, old('product_category'))) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.input label-name="Pret"
                attributes-param="type=number id=price required step=0.01 min=0 max=10000000000" name="price" />
            <x-admin.input label-name="Pozitie produs (default 99999)"
                attributes-param="type=number id=order step=1 min=0 max=100000000" name="order" />

            <div>
                <label for="description">Product description</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{!! old('description') !!}</textarea>
            </div>
            <br>
            <div>
                <label for="media">Adauga media pentru produs</label>
                <br>
                <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            </div>
            <br>
            <br>
            <button type="submit" name="action" value="preview" class="btn btn-outline-warning">Preview</button>
            <button type="submit" name="action" value="save" class="btn btn-primary">Adauga produs</button>
        </form>
    </div>
@endsection
