@extends('client.layout')

@section('title', 'Blog')

@section('content')
    <div id="blog-content">
        <div class="container py-5">
            <h1 class="text-white text-center">Blog</h1>
            {{-- First Page Custom Layout --}}
            @if ($posts->currentPage() === 1)
                <div class="row g-4 align-items-stretch mt-5">
                    @if ($posts[0])
                        <div class="col-8">
                            <x-client.post-card :post="$posts[0]" />
                        </div>
                    @endif

                    @if ($posts[1])
                        <div class="col-4 d-flex">
                            <x-client.post-card :post="$posts[1]" aspect="4/3" class="w-100 full-height-wrapper h-100" />
                        </div>
                    @endif

                </div>

                <div class="row g-4 mt-3">
                    @if ($posts[2])
                        <div class="col-6">
                            <x-client.post-card :post="$posts[2]" aspect="4/3" />
                        </div>
                    @endif
                    @if ($posts[3])
                        <div class="col-6">
                            <x-client.post-card :post="$posts[3]" aspect="4/3" />
                        </div>
                    @endif
                </div>
            @endif

            <div class="row g-4 mt-1">
                @foreach ($posts->slice($posts->currentPage() === 1 ? 4 : 0) as $post)
                    <div class="col-lg-3 col-md-6 col-12 mt-5">
                        <x-client.post-card :post="$post" aspect="3/4" showExcerpt="1" />
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-3">
                <x-client.pagination :paginator="$posts" />
            </div>
        </div>
    </div>
@endsection
