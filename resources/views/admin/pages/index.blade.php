@extends('admin.layout')

@section('title', 'Pagini')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestionare Pagini</h2>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Adaugă Pagină Nouă</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Titlu</th>
                    <th>Slug URL</th>
                    <th>Status</th>
                    <th>Tip</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td><strong>{{ $page->title }}</strong></td>
                        <td><code>/p/{{ $page->slug }}</code></td>
                        <td>
                            @if($page->is_active)
                                <span class="badge bg-success">Activ</span>
                            @else
                                <span class="badge bg-secondary">Inactiv</span>
                            @endif
                        </td>
                        <td>
                            @if($page->is_system)
                                <span class="badge bg-warning text-dark"><i class="bi bi-shield-lock"></i> Sistem</span>
                            @else
                                <span class="badge bg-info text-dark">Custom</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pages.edit', $page->slug) }}" class="btn btn-sm btn-outline-primary">Editează</a>
                            
                            @if(!$page->is_system)
                                <form action="{{ route('admin.pages.destroy', $page->slug) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Ești sigur că vrei să ștergi această pagină?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Șterge</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        {{ $pages->links() }}
    </div>
</div>
@endsection