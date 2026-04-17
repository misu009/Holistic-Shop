@extends('admin.layout')

@section('title', 'Editare Pagină')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Editare Pagină: {{ $page->title }}</h2>
        <x-alert-notification />

        @if ($page->is_system)
            <div class="alert alert-warning mb-4">
                <i class="bi bi-shield-lock"></i> Aceasta este o pagină de sistem. Titlul și statusul sunt protejate, dar
                poți edita conținutul textului.
            </div>
        @endif

        <form action="{{ route('admin.pages.update', $page->slug) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            @method('PUT')

            {{-- If system page, make title readonly --}}
            <x-admin.input label-name="Titlu Pagină"
                attributes-param="type=text id=title required {{ $page->is_system ? 'readonly' : '' }}" name="title"
                value="{{ $page->title }}" />

            <div class="mb-3 form-check form-switch mt-3">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                    {{ $page->is_active ? 'checked' : '' }} {{ $page->is_system ? 'disabled' : '' }}>
                <label class="form-check-label fw-bold" for="is_active">Vizibil pe site (Activ)</label>
                @if ($page->is_system)
                    <input type="hidden" name="is_active" value="1"> {{-- Ensures it stays active if disabled --}}
                @endif
            </div>

            <div class="mt-4">
                <label class="fw-bold mb-2">Conținut Pagină</label>
                <textarea name="content" id="content" rows="15" class="form-textarea ckeditor-media">{!! old('content', $page->content) !!}</textarea>
            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary me-2">Anulează</a>
                <button type="submit" class="btn btn-primary">Actualizează Pagina</button>
            </div>
        </form>
    </div>
@endsection
