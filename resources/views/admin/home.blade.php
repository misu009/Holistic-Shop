@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Vizitatori(30 zile)</h5>
                        <p class="display-6 fw-bold">{{ $totalVisits }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Useri</h5>
                        <p class="display-6 fw-bold">{{ $userCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total postari</h5>
                        <p class="display-6 fw-bold">{{ $postCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Produse</h5>
                        <p class="display-6 fw-bold">{{ $productCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Recent Blog Posts -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">Postari recente</div>
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
                    <div class="card-header bg-info text-white">Evenimente care urmeaza sa inceapa</div>
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
                    <div class="card-header bg-secondary text-white">Colaboratori recenti</div>
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
                    <div class="card-header bg-warning text-dark">Note admin</div>
                    <div class="card-body">
                        <textarea class="form-control" rows="5" placeholder="Write your notes here..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white">Actiuni rapide</div>
                    <div class="card-body text-center">
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary m-2">➕ Postare noua blog</a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success m-2">🛒 Adauga produs</a>
                        <a href="{{ route('admin.events.create') }}" class="btn btn-warning m-2">📅 Creaza eveniment</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary m-2">👤 Gestioneaza useri</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">Activitate recenta admin</div>
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
