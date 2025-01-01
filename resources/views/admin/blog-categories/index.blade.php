@extends('admin.layout')

@section('title', 'Blog Categories')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Categories</h2>
            <form action="{{ route('admin.blog-categories.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Add Category
                </button>
            </form>
        </div>
        <x-admin.categories-table :categories="$categories" />
    </div>

@endsection
