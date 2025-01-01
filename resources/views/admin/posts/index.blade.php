@extends('admin.layout')

@section('title', 'Blog Posts')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Posts</h2>
            <form action="{{ route('admin.posts.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Add Post
                </button>
            </form>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-6 col-11">
                @php
                    $searchFilter = [
                        ['value' => 1, 'option' => 'Ambele'],
                        ['value' => 2, 'option' => 'Produse'],
                        ['value' => 3, 'option' => 'Categorii'],
                    ];
                @endphp
                <x-admin.search-select2 route="admin.posts.search" :searchFilter="$searchFilter" :searchItems="$searchItems" :searchOption="$searchOption ?? null"
                    :searchRecord="$searchRecord ?? null" ajaxRoute="/admin/posts/update-select2" />
            </div>
        </div>
        <br>
        <x-admin.posts-table :posts="$posts" />
    </div>
@endsection
