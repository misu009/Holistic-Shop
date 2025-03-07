@extends('client.layout')

@section('title', 'Blog')

@section('content')
    <div class="container my-5">
        <h2 class="text-center text-white mb-4">Our Blog</h2>
        <div class="row g-4">
            @foreach ($posts as $index => $post)
                @if ($posts->currentPage() == 1 && $index < 3)
                    <!-- Special layout for first 4 posts on first page -->
                    @php
                        $cols = '4';
                        if ($index == 0) {
                            $cols = 'col-12';
                        } elseif ($index == 1) {
                            $cols = 'col-6';
                        } elseif ($index == 2) {
                            $cols = 'col-6';
                        }
                    @endphp
                    <div class="{{ $cols }}">
                        <div class="card h-100 text-white bg-dark border-light">
                            <img src="{{ !empty($post->media) && isset($post->media[0]) ? asset('storage/' . $post->media[0]->path) : asset('images/client/image-3.png') }}"
                                class="card-img-top" alt="{{ $post->title }}" height="330px">
                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Standard 3-column layout for other pages -->
                    <div class="col-md-4">
                        <div class="card h-100 text-white bg-dark border-light">
                            <img src="{{ !empty($post->media) && isset($post->media[0]) ? asset('storage/' . $post->media[0]->path) : asset('images/client/image-3.png') }}"
                                class="card-img-top" alt="{{ $post->title }}" height="330px">
                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <x-client.pagination :paginator="$posts" />
    </div>
@endsection

<style>
    .card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .card img {
        filter: brightness(50%);
        transition: all 0.3s ease-in-out;
    }

    .card:hover img {
        filter: brightness(80%);
    }

    .card-title {
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
    }
</style>
