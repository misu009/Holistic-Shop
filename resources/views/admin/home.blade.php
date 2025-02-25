@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Dashboard Stats -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Users</h5>
                        <p class="display-6 fw-bold">{{ $userCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Blog Posts</h5>
                        <p class="display-6 fw-bold">{{ $postCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Products</h5>
                        <p class="display-6 fw-bold">{{ $productCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Recent Blog Posts -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">Recent Blog Posts</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($posts as $post)
                                <li class="list-group-item">
                                    {{ $post->title }} - <span
                                        class="text-muted">{{ $post->updated_at->diffInDays(now()) }} days ago</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Events -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">Upcoming Events</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($events as $event)
                                <li class="list-group-item">
                                    {{ $event->name }} - <span class="text-muted">{{ $event->starts_at }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Collaborators Section -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">Recent Collaborators</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($collaborators as $collaborator)
                                <li class="list-group-item">{{ $collaborator->name }} - <span class="text-muted">Joined
                                        {{ $collaborator->created_at->diffInDays(now()) }} days ago </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Admin Notes Section -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark">Admin Notes</div>
                    <div class="card-body">
                        <textarea class="form-control" rows="5" placeholder="Write your notes here..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white">Quick Actions</div>
                    <div class="card-body text-center">
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary m-2">➕ New Blog Post</a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success m-2">🛒 Add Product</a>
                        <a href="{{ route('admin.events.create') }}" class="btn btn-warning m-2">📅 Create Event</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary m-2">👤 Manage Users</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">Recent Admin Activity</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($logs as $log)
                                <li class="list-group-item">
                                    <strong>{{ $log->user->name ?? 'Unknown User' }}</strong>
                                    {{ $log->action }}
                                    @if ($log->model && $log->model_id)
                                        on {{ $log->model }} (ID: {{ $log->model_id }})
                                    @endif
                                    <span class="text-muted"> - {{ $log->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
