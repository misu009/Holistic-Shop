@extends('admin.layout')

@section('title', 'Events')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Events</h2>
            <form action="{{ route('admin.events.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Add Event
                </button>
            </form>
        </div>
        <x-admin.events-table :events="$events" />
    </div>
@endsection
