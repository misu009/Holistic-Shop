@extends('client.layout')

@section('title')
    Serviciul {{ $service->name }} - {{ config('app.name') }}
@endsection

@section('content')
    @php
        $imageUrl = $service->picture;
    @endphp

    <section>
        <div style="height: 70vh; background-image: url('{{ asset('storage/' . $imageUrl) }}'); background-size: cover; background-position: center;"
            class="d-flex justify-content-center align-items-center">
            <div class="text-center text-white">
                {!! $settings->event_text_1 !!}
            </div>
        </div>
    </section>
    <div id="event-show" class="fs-5 pt-4">
        <div class="container my-4 text-white">

            <div class="mb-4">
                <h3 class="fw-bold">Descriere Servici</h3>
                <p>{!! $service->description !!}</p>
            </div>
            <br><br>
            <!-- Primary Collaborators -->
            @php
                $primary = $service->primaryCollaborators;
                $secondary = $service->nonPrimaryCollaborators;
            @endphp

            @if ($primary && $primary->isNotEmpty())
                <div class="mb-4">
                    <h5 class="fw-bold text-uppercase">Colaboratori Principali</h5>
                    <br>
                    @foreach ($primary as $collaborator)
                        <div class="d-flex mb-3 align-items-start text-white">
                            @if ($collaborator->picture)
                                <img src="{{ asset('storage/' . $collaborator->picture) }}" class="me-3 rounded-circle"
                                    style="width: 64px; height: 64px; object-fit: cover;" alt="{{ $collaborator->name }}">
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $collaborator->name }}</h6>
                                <p class="mb-1">{!! $collaborator->short_description !!}</p>
                                @if ($collaborator->email)
                                    <div><small><strong>Email:</strong> {{ $collaborator->email }}</small></div>
                                @endif
                                @if ($collaborator->phone_number)
                                    <div><small><strong>Telefon:</strong> {{ $collaborator->phone_number }}</small></div>
                                @endif
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            @endif

            <!-- Secondary Collaborators -->
            @if ($secondary && $secondary->isNotEmpty())
                <div class="mb-4">
                    <h6 class="fw-bold text-uppercase">Colaboratori Secundari</h6>
                    @foreach ($secondary as $collaborator)
                        <div class="d-flex mb-3 align-items-start">
                            @if ($collaborator->picture)
                                <img src="{{ asset('storage/' . $collaborator->picture) }}" class="me-3 rounded-circle"
                                    style="width: 48px; height: 48px; object-fit: cover;" alt="{{ $collaborator->name }}">
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $collaborator->name }}</h6>
                                <p class="mb-1 small ">{{ $collaborator->short_description }}</p>
                                @if ($collaborator->email)
                                    <div><small><strong>Email:</strong> {{ $collaborator->email }}</small></div>
                                @endif
                                @if ($collaborator->phone_number)
                                    <div><small><strong>Telefon:</strong> {{ $collaborator->phone_number }}</small></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
