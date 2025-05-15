@extends('client.layout')

@section('title', 'Contact')

@section('content')
    <section class="contact-section d-flex flex-column align-items-center justify-content-center text-center text-white">
        <h2 class="mb-5 display-5 fw-bold text-uppercase pb-2" style="color: var(--col1);">FORMULAR DE CONTACT</h2>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('client.contact.store') }}" method="POST" class="container mt-4">
            @csrf
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <!-- Name Input -->
                    <div class="form-group">
                        <input type="text" name="name" placeholder="NUMELE TĂU" class="form-control glass-input mb-3"
                            required value="{{ old('name') }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <input type="email" name="email" placeholder="ADRESA DE E-MAIL"
                            class="form-control glass-input mb-3" required value="{{ old('email') }}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Input -->
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="NUMĂRE DE TELEFON"
                            class="form-control glass-input" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Textarea -->
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea name="message" rows="7" placeholder="Cu ce te putem susține în această etapă a vieții tale?"
                            class="form-control glass-input">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-custom px-5 py-3">TRIMITE MESAJUL</button>
                </div>
            </div>
        </form>

        <p class="mt-5">• Ne gasiti si la linkurile din footer <br>
            @if ($settings->phone_number || $settings->email)
                • Ne puteti contacta
            @endif
            @if ($settings->phone_number)
                la numarul de telefon <strong>{{ $settings->phone_number }}</strong><br>
            @endif
            @if ($settings->phone_number || $settings->email)
                sau
            @endif
            @if ($settings->email)
                la adresa de e-mail <a href="mailto:{{ $settings->email }}"
                    class="text-decoration-none text-white"><strong>{{ $settings->email }}</strong></a>
            @endif
        </p>
    </section>
@endsection
