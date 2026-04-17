@extends('client.layout')

@section('title', $page->title)

@section('content')
    <div class="pt-5 mt-5">
        <div class="container py-5 bg-white rounded shadow-sm mb-5">
            <h1 class="text-center fw-bold mb-5" style="color: #5b2b12;">{{ $page->title }}</h1>

            <div class="page-content text-black px-md-5">
                {!! $page->content !!}
            </div>
        </div>
    </div>

    <style>
        .page-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .page-content p {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
