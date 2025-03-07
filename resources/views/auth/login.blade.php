<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css'])
    <title>Lotus Retreat</title>
</head>

<body>
    <div class="d-flex justify-content-center bg-white align-items-center vh-100">
        <div class="p-2 border bg-light rounded d-flex shadow-lg col-lg-6 col m-4">
            <div class="col-lg-6 p-lg-3 p-1 d-lg-flex justify-content-center align-items-center d-none">
                <img src="{{ asset('images/auth/security-key.jpg') }}" style="width: 70%" alt="Security Key">
            </div>
            <div class="col-lg-6 col">
                <x-alert-notification />

                <h3 class="text-uppercase text-center mt-5 mb-3">Log in</h3>
                <form method="POST" action="{{ route('sign.in') }}">
                    @csrf
                    {{-- <input class="rounded" type="email" name="email" id="email" placeholder="email"> --}}
                    <div class="input-group mt-4 p-3">
                        <div class="d-flex align-items-center justify-content-center me-2">
                            <img height="30px" src="{{ asset('images/email-1-svgrepo-com.svg') }}" alt="email">
                        </div>
                        <input type="email" name="email" id="email"
                            style="background-color: rgb(224,
                            224, 224)"
                            class="form-control" placeholder="Enter your email" aria-label="Email" required autofocus>
                    </div>
                    <div class="input-group mb-3 p-3">
                        <div class="d-flex align-items-center justify-content-center me-2">
                            <img height="25px" src="{{ asset('images/lock.svg') }}" alt="password">
                        </div>
                        <input type="password" name="password" id="password"
                            style="background-color: rgb(224, 224, 224)" class="form-control"
                            placeholder="Enter your password" aria-label="Email" required>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror


                    <div class="w-100 p-3 d-flex justify-content-between">
                        <div>
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" checked>
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>
                        <button class="btn btn-primary flex-end" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</body>

</html>
