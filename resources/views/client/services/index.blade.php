@extends('client.layout')

@section('title', 'Servicii')

@section('content')
    <section>
        <div style="height: 70vh; background-image: url('{{ asset('storage/' . $settings->event_img) }}'); background-size: cover; background-position: center;"
            class="d-flex justify-content-center align-items-center">
            <div class="text-center text-white">
                {!! $settings->event_text_1 !!}
            </div>
        </div>
    </section>

    @if ($services->isEmpty())
        <p class="text-center text-white">Nu s-au publicat servicii inca..</p>
    @else
        <section id="event-content">
            <div class="container py-5">
                <div class="row g-4">
                    @foreach ($services as $service)
                        @php
                            $imageUrl = $service->picture;
                        @endphp
                        <div class="col-md-6">
                            <a href="{{ route('client.services.show', ['id' => $service->id]) }}"
                                class="text-decoration-none">
                                <div class="p-3 rounded" style="border: 2px solid #0FB0F9;">
                                    <div class="position-relative rounded overflow-hidden;">
                                        <img src="{{ asset('storage/' . $imageUrl) }}" alt="service Image"
                                            class="img-fluid w-100 rounded" style="height: 20vh; object-fit: cover;">
                                    </div> <br>
                                    <div class="text-white text-center p-3 mt-2 rounded" style="background-color: #064765;">
                                        <h5 class="mb-1 fw-bold">{{ $service->name }}</h5>
                                        <small>{!! \Illuminate\Support\Str::words($service->description, 4, '..') !!}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <x-client.pagination :paginator="$services" />
                </div>

            </div>
        </section>
    @endif
@endsection
