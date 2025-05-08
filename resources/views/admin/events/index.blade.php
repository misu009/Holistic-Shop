@extends('admin.layout')

@section('title', 'Evenimente')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Evenimente</h2>
            <form action="{{ route('admin.events.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Adauga eveniment
                </button>
            </form>
        </div>
        <x-admin.events-table :events="$events" />
    </div>
@endsection
