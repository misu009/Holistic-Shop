<nav class="navbar dark navbar-expand-lg border-bottom border-body fixed-top" data-bs-theme="dark">
    <div class="container-fluid ps-0">
        <div class="ps-md-5 ps-3">
            <a class="navbar-brand  d-none d-sm-block" href="{{ route('home') }}"><img
                    src="{{ asset('images/client/LOGO-NAV-BAR.png') }}" alt="LOTUS RETREAT"></a>
            <a class="navbar-brand  d-block d-sm-none" href="#">
                <img src="{{ asset('images/client/navbar-logo-2.png') }}" alt="LOTUS RETREAT">
                <img src="{{ asset('images/client/navbar-logo-2-part2.png') }}" alt="LOTUS RETREAT">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="ps-md-5 ps-3 collapse navbar-collapse" id="navbarColor01"
            style="background-color: black; margin-right: auto">
            <ul class=" navbar-nav ms-auto me-5 mb-2 mb-lg-0" style="background-color: black;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} ms-2 me-2" aria-current="page"
                        href="{{ route('home') }}">ACASA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.shop.index') ? 'active' : '' }} ms-2 me-2"
                        aria-current="page" href="{{ route('client.shop.index') }}">SHOP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.posts.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.posts.index') }}">BLOG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.events.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.events.index') }}">EVENIMENTE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.collaborators.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.collaborators.index') }}">ECHIPA NOASTRA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.contact.index') ? 'active' : '' }} ms-2 me-2"
                        href="{{ route('client.contact.index') }}">CONTACT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ms-2 me-2" href="#" data-bs-toggle="modal" data-bs-target="#donatiiModal">
                        DONAȚII
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="donatiiModal" tabindex="-1" aria-labelledby="donatiiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="donatiiModalLabel">Informații pentru donații</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Închide"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nume cont:</strong> {{ $settings->data ?? 'N/A' }}</p>
                <p><strong>IBAN:</strong> {{ $settings->iban ?? 'N/A' }}</p>
                <p><strong>Email:</strong>
                    <a href="mailto:{{ $settings->email }}"
                        class="text-decoration-none text-dark">{{ $settings->email ?? 'N/A' }}</a>
                </p>
                <p><strong>Telefon:</strong>
                    <a href="tel:{{ $settings->phone_number }}"
                        class="text-decoration-none text-dark">{{ $settings->phone_number ?? 'N/A' }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
