@extends('client.layout')

@section('title', 'Echipa noastra')

@section('content')
    <section class="container py-5">
        <div class="d-none d-lg-block">
            <div class="row justify-content-center">
                @foreach ($paginatedCollaborators as $collaborator)
                    <div class="col-md-8 mb-5">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ Storage::url($collaborator->picture) }}" class="img-fluid">
                            </div>
                            <div class="col-md-9">
                                <h2 class="fw-bold text-white">{{ $collaborator->name }}</h2>
                                <p class="text-white">
                                    {{ $collaborator->long_description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <x-client.pagination :paginator="$paginatedCollaborators" />
            </div>
        </div>
        <div id="teamCarousel" class="carousel slide d-lg-none position-relative" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($collaborators as $index => $collaborator)
                    <div class="carousel-item  {{ $index == 0 ? 'active' : '' }} text-center"
                        style="background-color: #043248; padding: 20px; border-radius: 10px;">
                        <img src="{{ Storage::url($collaborator->picture) }}" class="img-fluid mb-3">
                        <h2 class="fw-bold text-white mt-5">{{ $collaborator->name }}</h2>
                        <p class="text-white">
                            {{ $collaborator->long_description }}
                        </p>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev mt-2" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next mt-2" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true" style="bottom: auto !important;"></span>
            </button>
        </div>
    </section>
    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
@endsection
