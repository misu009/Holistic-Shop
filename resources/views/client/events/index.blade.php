@extends('client.layout')

@section('title', 'Evenimente')

@section('content')
    <section>
        <div style="height: 70vh; background-image: url('{{ asset('storage/' . $settings->event_img) }}'); background-size: cover; background-position: center;"
            class="d-flex justify-content-center align-items-center">
            <div class="text-center text-white">
                {!! $settings->event_text_1 !!}
            </div>
        </div>
    </section>

    @if ($events->isEmpty())
        <p class="text-center text-white">Nu s-au publicat evenimente inca..</p>
    @else
        <section id="event-content">
            <div class="container py-5">
                <div class="row g-4">
                    @foreach ($events as $event)
                        @php
                            $imageUrl = optional($event->media->first())->path;
                        @endphp
                        <div class="col-md-6">
                            <a href="{{ route('client.events.show', ['id' => $event->id]) }}" class="text-decoration-none">
                                <div class="p-3 rounded" style="border: 2px solid #0FB0F9;">
                                    <div class="position-relative rounded overflow-hidden;">
                                        <img src="{{ asset('storage/' . $imageUrl) }}" alt="Event Image"
                                            class="img-fluid w-100 rounded" style="height: 20vh; object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 m-2 px-2 py-1 rounded text-white fw-bold"
                                            style="background-color: #064765;">
                                            {{ \Carbon\Carbon::parse($event->starts_at)->translatedFormat('d F') }}
                                        </div>
                                    </div> <br>
                                    <div class="text-white text-center p-3 mt-2 rounded" style="background-color: #064765;">
                                        <h5 class="mb-1 fw-bold">{{ $event->name }}</h5>
                                        <small>{!! \Illuminate\Support\Str::words($event->description, 4, '..') !!}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <x-client.pagination :paginator="$events" />
                </div>

            </div>
        </section>
    @endif
@endsection
