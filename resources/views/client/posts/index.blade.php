@extends('client.layout')

@section('title', 'Blog')

@section('content')
    <div class="container my-5">
        <h2 class="text-center text-white mb-4">Our Blog</h2>
        <div class="row g-4">
            @foreach ($posts as $index => $post)
                @php
                    $ind = $posts->firstItem() + $index;
                    $cols = 'col-md-4';
                    if ($ind == 1) {
                        $cols = 'col-12';
                    } elseif ($ind == 2) {
                        $cols = 'col-6';
                    } elseif ($ind == 3) {
                        $cols = 'col-6';
                    }
                @endphp
                <div class="{{ $cols }}">
                    <div class="card h-100 text-white bg-dark border-light">
                        <img src="{{ !empty($post->media) && isset($post->media[0]) ? asset('storage/' . $post->media[0]->path) : asset('images/client/image-3.png') }}"
                            class="card-img-top" alt="{{ $post->title }}" height="330px">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                            <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                            <p class="card-content">{!! $post->excerpt !!}</p>
                        </div>
                    </div>
                </div>
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
