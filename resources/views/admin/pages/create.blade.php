@extends('admin.layout')

@section('title', 'Adaugă Pagină')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Adaugă o pagină nouă</h2>
        <x-alert-notification />

        <form action="{{ route('admin.pages.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf

            {{-- Using your custom component --}}
            <x-admin.input label-name="Titlu Pagină" attributes-param="type=text id=title required" name="title" />

            <div class="mb-3 form-check form-switch mt-3">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
                <label class="form-check-label fw-bold" for="is_active">Vizibil pe site (Activ)</label>
            </div>

            <div class="mt-4">
                <label class="fw-bold mb-2">Conținut Pagină</label>
                {{-- Class 'ckeditor-media' triggers your JS with upload support --}}
                <textarea name="content" id="content" rows="15" class="form-textarea ckeditor-media">{!! old('content') !!}</textarea>
            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary me-2">Anulează</a>
                <button type="submit" class="btn btn-primary">Salvează Pagina</button>
            </div>
        </form>
    </div>
@endsection
