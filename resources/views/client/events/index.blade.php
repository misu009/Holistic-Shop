@extends('client.layout')

@section('title', 'Evenimente')

@section('content')
    <section>
        {{-- @dd($settings) --}}
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
        @foreach ($events as $event)
            @php
                $imageUrl = optional($event->media->first())->path;
            @endphp
            <div class="container mt-5">
                <div style="
    background-image: url('{{ asset('images/client/event-bg.png') }}');
    background-size: 100% 100%; /* Stretches image to fill both width and height */
    background-repeat: no-repeat; /* Optional: prevents repeating */
    background-position: center;  /* Optional: centers image */
"
                    class="row">
                    <div class="col-4">
                        <div>
                            <h3 class="text-white">{{ $event->starts_at }}</h3>
                        </div>
                        <div class="p-md-5 p-1 d-flex align-items-center" style="height: 100%">
                            <img src="{{ Storage::url($imageUrl) }}" alt="event image"
                                style="width: 100%; height: 80%; object-fit: cover; ">
                        </div>
                    </div>
                    <div class="col-8 p-5 text-white">
                        <h2>{{ $event->name }}</h2>
                        {!! $event->description !!}
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
