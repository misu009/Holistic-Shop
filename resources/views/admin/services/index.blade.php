@extends('admin.layout')

@section('title', 'Servicii')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Servicii</h2>
            <form action="{{ route('admin.services.create') }}" method="GET">
                <button type="submit" class="btn btn-primary">
                    Adauga Serviciu
                </button>
            </form>
        </div>
        <x-admin.services-table :services="$services" />
    </div>
@endsection
