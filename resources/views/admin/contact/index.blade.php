@extends('admin.layout')

@section('title', 'Contact')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">Mesaje</h2>
        </div>
        <x-admin.contact-us-table :contacts="$contacts" />
    </div>
@endsection
