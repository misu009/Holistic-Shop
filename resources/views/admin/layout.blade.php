<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/client/navbar-logo-2.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>

<body>
    @php
        $navLinks = [
            ['name' => 'Home', 'url' => '/admin'],
            ['name' => 'Utilizatori', 'url' => '/admin/users'],
            ['name' => 'Profil', 'url' => '/admin/profile'],
            ['name' => 'Categorii postari', 'url' => '/admin/blog-categories'],
            ['name' => 'Postari', 'url' => '/admin/posts'],
            ['name' => 'Categorii Produse', 'url' => '/admin/shop-categories'],
            ['name' => 'Produse', 'url' => '/admin/products'],
            ['name' => 'Colaboratori', 'url' => '/admin/collaborators'],
            ['name' => 'Evenimente', 'url' => '/admin/events'],
            ['name' => 'Setari', 'url' => '/admin/settings'],
            ['name' => 'Contact', 'url' => '/admin/contact'],
        ];
    @endphp

    <div class="d-flex ">
        <x-admin.sidebar :links="$navLinks" />
        <div id="content" class="flex-grow-1 content content-margin">
            <div class="toggle-sidebar p-2 mb-2 bg-dark text-white">
                <i class="bi bi-list"></i> Toggle Sidebar
            </div>
            @yield('content')
        </div>
    </div>
</body>

<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    document.querySelector('.toggle-sidebar').addEventListener('click', () => {
        sidebar.classList.toggle('d-none');
        content.classList.toggle('content-margin');
    });
</script>

</html>
