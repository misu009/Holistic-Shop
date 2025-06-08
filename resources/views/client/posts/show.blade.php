@extends('client.layout')

@section('title')
    {{ $post->title }} - {{ $post->slug }} {{ config('app.name') }}
@endsection

@section('content')
    <div id="blog">
        <div class="container text-white" style="margin-top:100px !important;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('client.posts.show', $prevPost->slug) }}" class="btn btn-outline-info">
                    <i class="bi bi-arrow-left"></i> ÎNAPOI
                </a>
                @if (isset($preview))
                    <h1 class="text-danger text-center">!!Acesta este doar un preview!! Postarea nu a fost salvata inca</h1>
                @endif
                <a href="{{ route('client.posts.show', $nextPost->slug) }}" class="btn btn-outline-info">
                    VEZI URMĂTORUL ART. <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @php
                $allMedia = $post->media;
                if (isset($preview)) {
                    $allMedia = $previewMedia;
                }
            @endphp

            <div class="position-relative mt-5 mb-5">
                <div class="swiper mySwiper mb-4 px-5">
                    <div class="swiper-wrapper">
                        @foreach ($allMedia as $media)
                            <div class="swiper-slide">
                                <div class="ratio ratio-4x3 bg-dark rounded overflow-hidden shadow-sm">
                                    @if (Str::endsWith($media->path, ['.mp4', '.webm']))
                                        <a href="{{ asset('storage/' . $media->path) }}" class="glightbox"
                                            data-gallery="product-gallery" data-type="video"
                                            data-source="{{ asset('storage/' . $media->path) }}"
                                            data-poster="{{ asset('storage/' . $media->path) }}">
                                            <video class="w-100 h-100 object-fit-cover" muted playsinline>
                                                <source src="{{ asset('storage/' . $media->path) }}">
                                            </video>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $media->path) }}" class="glightbox"
                                            data-gallery="product-gallery" data-type="image" data-title="">
                                            <img src="{{ asset('storage/' . $media->path) }}"
                                                class="w-100 h-100 object-fit-cover" alt="">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="custom-swiper-nav custom-prev">
                    <i class="bi bi-chevron-left"></i>
                </div>
                <div class="custom-swiper-nav custom-next">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>

            <div class="d-flex flex-wrap align-items-center gap-3">
                <span class="fs-5">{{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('j F, Y') }}</span>

                <i class="bi bi-tag"></i>
                @foreach ($post->categories as $category)
                    <a href="{{ route('client.categories.show', $category->id) }}" class="text-decoration-none">
                        <span
                            class="btn btn-outline-info badge rounded-pill text-white border border-info px-3 py-2 text-wrap">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach

                @php
                    use Illuminate\Support\Str;
                    $collaborator = \App\Models\Collaborator::where('name', $post->created_by)->first();
                @endphp

                <span class="ms-auto text-uppercase">
                    <small class="text-lowercase">Scris de: </small>
                    @if ($collaborator)
                        <a href="{{ route('client.collaborators.index') }}" class="text-info text-decoration-none">
                            {{ $collaborator->name }}
                        </a>
                    @else
                        {{ $post->created_by ?? 'Autor necunoscut' }}
                    @endif
                </span>
            </div>
            <div class="" style="margin-top: 4rem; margin-bottom: 4rem;">
                <h2>{{ $post->title }}</h2>
                <div id="editorjs-view"></div>
            </div>
        </div>
    </div>
    <script>
        window.editorJsData = {!! $post->description !!};
    </script>
@endsection
