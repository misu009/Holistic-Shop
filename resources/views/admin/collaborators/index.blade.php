@extends('admin.layout')

@section('title', 'Colaboratori')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Colaboratori</h2>
            <form action="{{ route('admin.collaborators.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Adauga colaborator
                </button>
            </form>
        </div>
        <x-admin.collaborators-table :collaborators="$collaborators" />
    </div>
@endsection
