@extends('admin.layout')

@section('title', 'Comenzi')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Comenzi</h2>
        </div>
        <x-admin.orders-table :orders="$orders" />
    </div>
@endsection
