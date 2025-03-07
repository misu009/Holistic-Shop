@extends('admin.layout')

@section('title', 'Admin Settings')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">Main Page Settings</div>
            <div class="card-body">
                <x-alert-notification />
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf

                    <!-- Mission Statement -->
                    <div class="mb-3">
                        <label class="form-label">Mission Text</label>
                        <textarea class="form-control" name="mission_text" required>{{ old('mission_text', $settings->mission_text) }}</textarea>
                    </div>

                    <!-- Mission Bullets -->
                    <div class="mb-3">
                        <label class="form-label">Mission Bullet Points (8)</label>
                        @foreach (range(0, 7) as $index)
                            <input type="text" class="form-control mb-2" name="mission_bullets[]"
                                value="{{ old("mission_bullets.$index", $settings->mission_bullets[$index] ?? '') }}"
                                required>
                        @endforeach
                    </div>

                    <!-- About Us -->
                    <div class="mb-3">
                        <label class="form-label">About Us</label>
                        <textarea class="form-control" name="about_text" rows="5" required>{{ old('about_text', $settings->about_text) }}</textarea>
                    </div>

                    <!-- Featured Blog Posts -->
                    <div class="mb-3">
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


                    <!-- Featured Products -->
                    <div class="mb-3">
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

                    <button type="submit" class="btn btn-success">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
@endsection
