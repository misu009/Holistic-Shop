@extends('admin.layout')

@section('title', 'Adauga serviciu')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Adauga un serviciu nou</h2>
        <x-alert-notification />
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-admin.input label-name="Serviciu Name" attributes-param="type=text id=name required" value="{{ old('name') }}"
                name="name" />
            <div>
                <label for="description">Descriere</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{{ old('description') }}</textarea>
            </div>
            <br>

            <div>
                <label for="primary_collaborators">
                    Colaboratori principali
                </label>
                <select class="form-control select2" multiple="multiple" name="primary_collaborators[]"
                    id="primary_collaborators" required>
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (old('primary_collaborators') && in_array($collaborator->id, old('primary_collaborators'))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="secondary_collaborator">
                    Colaboratori secundari<span class="text-danger">(optional)</span>
                </label>
                <select class="form-control select2" multiple="multiple" name="secondary_collaborators[]"
                    id="secondary_collaborator">
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (old('secondary_collaborators') && in_array($collaborator->id, old('secondary_collaborators'))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-admin.input label-name="Pret"
                attributes-param="type=number id=price required step=0.01 min=0 max=10000000000" name="price" />
            <div>
                <label for="media">Adauga media pentru serviciu</label>
                <br>
                <input type="file" id="picture" name="picture" accept="image/*" required>
            </div>
            <br>
            <div>
                <label for="disabled">Dezactiveaza serviciu (check pentru a dezactiva)</label>
                <input type="checkbox" name="disabled" id="disabled" value="1"
                    @if (old('disabled') == 1) checked @endif>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Add Serviciu</button>
        </form>
    </div>
@endsection
