<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/client/navbar-logo-2.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/css/client.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        @include('components.client.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('components.client.footer')
    </footer>
</body>

</html>
