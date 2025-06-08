@extends('admin.layout')

@section('title', 'Actualizeaza Serviciu')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Actualizeaza Serviciu</h2>
        <x-alert-notification />
        <form action="{{ route('admin.services.update', ['service' => $service->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-admin.input label-name="Nume servici" attributes-param="type=text id=name required"
                value="{{ old('name') ? old('name') : $service->name }}" name="name" />
            <div>
                <label for="description">Descriere</label>
                <br>
                <textarea name="description" id="description" rows="4" class="form-textarea ckeditor">{{ old('description') ? old('description') : $service->description }}</textarea>
            </div>
            <br>

            <div>
                <label for="primary_collaborators">Colaboratori principali</label>
                <select class="form-control select2" multiple="multiple" name="primary_collaborators[]"
                    id="primary_collaborators" required>
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (
                            (old('primary_collaborators') && in_array($collaborator->id, old('primary_collaborators'))) ||
                                (!old('primary_collaborators') &&
                                    in_array($collaborator->id, $service->primaryCollaborators->pluck('id')->toArray()))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label for="secondary_collaborator">Colaboratori secundari</label> <span
                    class="text-danger">(optional)</span>
                <select class="form-control select2" multiple="multiple" name="secondary_collaborators[]"
                    id="secondary_collaborator">
                    <option value=""></option>
                    @foreach ($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}" @if (
                            (old('secondary_collaborators') && in_array($collaborator->id, old('secondary_collaborators'))) ||
                                (!old('secondary_collaborators') &&
                                    in_array($collaborator->id, $service->nonPrimaryCollaborators->pluck('id')->toArray()))) selected @endif>
                            {{ $collaborator->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-admin.input label-name="Pret" value="{{ old('price', $service->price) }}"
                attributes-param="type=number id=price required step=0.01 min=0 max=10000000000" name="price" />
            <x-admin.image-uploader imagePreviewId="image-preview" path="{{ Storage::url($service->picture) }}"
                imageInputId="select-picture" imageInputName="image" buttonText="Upload Image" />

            <br> <br>
            <div>
                <label for="disabled">Dezactiveaza servici (check pentru a dezactiva)</label>
                <input type="checkbox" name="disabled" id="disabled" value="1"
                    @if (old('disabled') == 1) checked @elseif ($service->disabled == 1) checked @endif>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Actualizeaza servici</button>
        </form>
        <br>
    </div>
@endsection
