@extends('client.layout')

@section('title', 'Blog')

@section('content')
    <div id="blog-content" class="text-black">
        <div class="container py-5">
            <h1 class="text-center">Blog</h1>

            {{-- Fallback if the blog is completely empty --}}
            @if ($posts->isEmpty())
                <div class="text-center mt-5">
                    <h3 class="text-black">Nu exista articole pe blog momentan.</h3>
                </div>
            @else
                {{-- First Page Custom Layout --}}
                @if ($posts->currentPage() === 1)
                    <div class="row g-4 align-items-stretch mt-5">
                        {{-- Safely check if the post exists using isset() --}}
                        @if (isset($posts[0]))
                            <div class="col-lg-8 col-12">
                                <x-client.post-card :post="$posts[0]" />
                            </div>
                        @endif

                        @if (isset($posts[1]))
                            <div class="col-lg-4 col-12 d-flex">
                                <x-client.post-card :post="$posts[1]" aspect="4/3"
                                    class="w-100 full-height-wrapper h-100" />
                            </div>
                        @endif
                    </div>

                    <div class="row g-4 mt-3">
                        @if (isset($posts[2]))
                            <div class="col-md-6 col-12">
                                <x-client.post-card :post="$posts[2]" aspect="4/3" />
                            </div>
                        @endif

                        @if (isset($posts[3]))
                            <div class="col-md-6 col-12">
                                <x-client.post-card :post="$posts[3]" aspect="4/3" />
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Remaining Posts Grid --}}
                <div class="row g-4 mt-1">
                    @foreach ($posts->slice($posts->currentPage() === 1 ? 4 : 0) as $post)
                        <div class="col-lg-3 col-md-6 col-12 mt-5">
                            <x-client.post-card :post="$post" aspect="3/4" showExcerpt="1" />
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-5">
                    <x-client.pagination :paginator="$posts" />
                </div>
            @endif
        </div>
    </div>
@endsection
