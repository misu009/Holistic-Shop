<nav class="navbar dark navbar-expand-lg border-bottom border-body fixed-top" data-bs-theme="dark">
    <div class="container-fluid ">
        <a class="navbar-brand ms-5 d-none d-sm-block" href="{{ route('home') }}"><img
                src="{{ asset('images/client/LOGO-NAV-BAR.png') }}" alt="LOTUS RETREAT"></a>
        <a class="navbar-brand ms-5 d-block d-sm-none" href="#">
            <img src="{{ asset('images/client/navbar-logo-2.png') }}" alt="LOTUS RETREAT">
            <img src="{{ asset('images/client/navbar-logo-2-part2.png') }}" alt="LOTUS RETREAT">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01" style="background-color: black; margin-right: auto">
            <ul class="navbar-nav ms-auto me-5 mb-2 mb-lg-0" style="background-color: black;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} ms-2 me-2" aria-current="page"
                        href="{{ route('home') }}">ACASA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ms-2 me-2" href="">SHOP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.posts.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.posts.index') }}">BLOG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.collaborators.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.collaborators.index') }}">EVENIMENTE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.collaborators.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.collaborators.index') }}">ECHIPA NOASTRA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ms-2 me-2" href="#">CONTACT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
