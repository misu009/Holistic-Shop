<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/client/navbar-logo-2.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/css/client.css', 'resources/js/client.js'])
</head>

{{-- 1. Add these classes to the body --}}

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('components.client.header')
    </header>

    {{-- 2. Add flex-grow-1 to the main tag --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer>
        @include('components.client.footer')
    </footer>
</body>

</html>
