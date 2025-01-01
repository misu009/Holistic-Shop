@extends('admin.layout')

@section('title', 'Collaborators')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Collaborators</h2>
            <form action="{{ route('admin.collaborators.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Add Collaborator
                </button>
            </form>
        </div>
        <x-admin.collaborators-table :collaborators="$collaborators" />
    </div>
@endsection
