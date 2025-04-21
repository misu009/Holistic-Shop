@extends('admin.layout')

@section('title', 'Admin Settings')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">

            <x-alert-notification />
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">Main Page Settings</div>
                <div class="card-body">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Texte Hero</label>
                        <input type="text" class="form-control shadow mb-2" name="hero_text_1" maxlength="30"
                            value="{{ old('hero_text_1', $settings->hero_text_1) }}" required>
                        <input type="text" class="form-control shadow mb-2" name="hero_text_2" maxlength="90"
                            value="{{ old('hero_text_2', $settings->hero_text_2) }}" required>
                        <input type="text" class="form-control shadow mb-2" name="hero_text_3" maxlength="110"
                            value="{{ old('hero_text_3', $settings->hero_text_3) }}" required>
                    </div>

                    <div class="mb-3 mt-5">
                        <label class="form-label">Mission Text</label>
                        <textarea class="form-control shadow" name="mission_text" required>{{ old('mission_text', $settings->mission_text) }}</textarea>
                    </div>

                    <div class="mb-3 mt-5">
                        <label class="form-label">Mission Bullet Points (8)</label>
                        @foreach (range(0, 7) as $index)
                            <input type="text" class="form-control mb-2 shadow" name="mission_bullets[]"
                                value="{{ old("mission_bullets.$index", $settings->mission_bullets[$index] ?? '') }}"
                                required>
                        @endforeach
                    </div>

                    <div class="mb-3 mt-5">
                        <label class="form-label">About Us</label>
                        <textarea class="form-control ckeditor" name="about_text" rows="5" required>{{ old('about_text', $settings->about_text) }}</textarea>
                    </div>

                    <div class="mb-3 mt-5">
                        <label class="form-label">Select 3 Blog Posts for Homepage</label>
                        <select class="form-select select2" name="selected_blog_posts[]" multiple required>
                            @foreach ($blogPosts as $post)
                                <option value="{{ $post->id }}"
                                    {{ in_array($post->id, old('selected_blog_posts', $settings->selected_blog_posts ?? [])) ? 'selected' : '' }}>
                                    {{ $post->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 mt-5">
                        <label class="form-label">Select 4 Featured Products</label>
                        <select class="form-select select2" name="selected_products[]" multiple required>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ in_array($product->id, old('selected_products', $settings->selected_products ?? [])) ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Navbar Links -->
                    {{-- <div class="mb-3">
                        <label class="form-label">Navbar Links</label>
                        <div id="navbar-links">
                            @php
                                $defaultLinks = [
                                    ['name' => 'Home', 'url' => '/'],
                                    ['name' => 'Shop', 'url' => '/shop'],
                                    ['name' => 'Blog', 'url' => '/blog'],
                                    ['name' => 'About', 'url' => '/about'],
                                    ['name' => 'Contact', 'url' => '/contact'],
                                ];
                                $navbarLinks = old('navbar_links', $settings->navbar_links ?? $defaultLinks);
                            @endphp

                            @foreach ($navbarLinks as $index => $link)
                                <div class="d-flex align-items-center mb-2 navbar-link-item">
                                    <input type="text" class="form-control me-2"
                                        name="navbar_links[{{ $index }}][name]" value="{{ $link['name'] }}"
                                        required>
                                    <input type="text" class="form-control me-2"
                                        name="navbar_links[{{ $index }}][url]" value="{{ $link['url'] }}"
                                        required>
                                    <button type="button" class="btn btn-danger remove-link">X</button>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-header bg-warning text-white">Shop Page Settings</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Texte Shop Hero</label>
                        <textarea name="shop_text_1" id="shop_text_1" class="ckeditor form-control" rows="3" required>
                            {!! old('shop_text_1', $settings->shop_text_1) !!}
                        </textarea>
                        <br>
                        <textarea name="shop_text_2" id="shop_text_2" class="ckeditor form-control" rows="3" required>
                            {!! old('shop_text_2', $settings->shop_text_2) !!}
                        </textarea>
                        <br>
                        <label class="form-label">Text button hero shop</label>
                        <input type="text" class="form-control shadow mb-2" name="shop_text_3" maxlength="40"
                            value="{{ old('shop_text_3', $settings->shop_text_3) }}" required>
                    </div>

                    <div class="mb-3 mt-5">
                        <label class="form-label">Poze Shop</label>
                        <br>
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <x-admin.image-uploader imagePreviewId="image-preview-1"
                                    path="{{ Storage::url($settings->shop_img_1) }}" imageInputId="select-picture-1"
                                    imageInputName="shop_img_1" buttonText="Upload Image" />
                            </div>
                            <div class="col-md-3 col-6">
                                <x-admin.image-uploader imagePreviewId="image-preview-2"
                                    path="{{ Storage::url($settings->shop_img_2) }}" imageInputId="select-picture-2"
                                    imageInputName="shop_img_2" buttonText="Upload Image" />
                            </div>
                            <div class="col-md-3 col-6">
                                <x-admin.image-uploader imagePreviewId="image-preview-3"
                                    path="{{ Storage::url($settings->shop_img_3) }}" imageInputId="select-picture-3"
                                    imageInputName="shop_img_3" buttonText="Upload Image" />
                            </div>
                            <div class="col-md-3 col-6">
                                <x-admin.image-uploader imagePreviewId="image-preview-4"
                                    path="{{ Storage::url($settings->shop_img_4) }}" imageInputId="select-picture-4"
                                    imageInputName="shop_img_4" buttonText="Upload Image" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm border-0 mt-5">
                <div class="card-header bg-danger text-white">Events Page Settings</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Text Event Hero</label>
                        <textarea name="event_text_1" id="event_text_1" class="ckeditor form-control" rows="3" required>
                            {!! old('event_text_1', $settings->event_text_1) !!}
                        </textarea>
                    </div>
                    <div class="mb-3 mt-5">
                        <label class="form-label">Poze Event Hero</label>
                        <br>
                        <x-admin.image-uploader imagePreviewId="image-preview-event"
                            path="{{ Storage::url($settings->event_img) }}" imageInputId="select-event-img"
                            imageInputName="event_img" buttonText="Upload Event Hero Image" />
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-success mt-5">Save Settings</button>
        </form>
    </div>
@endsection
