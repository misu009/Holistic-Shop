<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top">
    <div class="container-fluid ps-0 pe-0">
        <!-- brand -->
        <a class="navbar-brand ps-3 ps-md-5" href="{{ route('home') }}">
            <img src="{{ asset('images/client/LOGO-NAV-BAR.png') }}" alt="LOTUS RETREAT">
        </a>

        <!-- toggler -->
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- collapse -->
        <div class="collapse navbar-collapse bg-light ps-3 ps-md-5" id="mainNavbar">
            <ul class="navbar-nav ms-auto me-md-5 mb-2 mb-xl-0 text-left">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">ACASA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.shop.index') ? 'active' : '' }}"
                        href="{{ route('client.shop.index') }}">SHOP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.posts.index') ? 'active' : '' }}"
                        href="{{ route('client.posts.index') }}">BLOG</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('client.events.index', 'client.services.index') ? 'active' : '' }}"
                        href="#" id="navbarEventsDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        EXPERIENTE
                    </a>
                    <ul class="dropdown-menu bg-light" aria-labelledby="navbarEventsDropdown">
                        <li><a class="dropdown-item {{ request()->routeIs('client.events.index') ? 'active' : '' }}"
                                href="{{ route('client.events.index') }}">Evenimente</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('client.services.index') ? 'active' : '' }}"
                                href="{{ route('client.services.index') }}">Servicii</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.collaborators.index') ? 'active' : '' }}"
                        href="{{ route('client.collaborators.index') }}">ECHIPA NOASTRA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.contact.index') ? 'active' : '' }}"
                        href="{{ route('client.contact.index') }}">CONTACT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#donatiiModal">SUSTINE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.cart.index') ? 'active' : '' }}"
                        href="{{ route('client.cart.index') }}">
                        <i class="bi bi-cart h5"></i>
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
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->phone_number) }}" target="_blank"
                        class="text-decoration-none text-dark">
                        {{ $settings->phone_number ?? 'N/A' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
