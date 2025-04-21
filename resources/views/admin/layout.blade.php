<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>

<body>
    @php
        $navLinks = [
            ['name' => 'Home', 'url' => '/admin'],
            ['name' => 'Users', 'url' => '/admin/users'],
            ['name' => 'Profile', 'url' => '/admin/profile'],
            ['name' => 'Post Categories', 'url' => '/admin/blog-categories'],
            ['name' => 'Posts Blog', 'url' => '/admin/posts'],
            ['name' => 'Product Categories', 'url' => '/admin/shop-categories'],
            ['name' => 'Products', 'url' => '/admin/products'],
            ['name' => 'Collaborators', 'url' => '/admin/collaborators'],
            ['name' => 'Events', 'url' => '/admin/events'],
            ['name' => 'Settings', 'url' => '/admin/settings'],
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
