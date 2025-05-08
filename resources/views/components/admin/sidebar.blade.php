<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
    <!-- Logo / Title -->
    <a href="{{ route('admin.index') }}"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-5 fw-bold">Panel Admin</span>
    </a>

    <hr>

    <!-- Navigation Links -->
    <ul class="nav nav-pills flex-column mb-auto">
        @foreach ($links as $link)
            <li class="nav-item">
                <a href="{{ $link['url'] }}"
                    class="nav-link text-secondary {{ request()->is(ltrim($link['url'], '/')) ? 'active text-white' : '' }}">
                    {{ $link['name'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <hr>

    <div class="mt-auto">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown">
                <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/default-user.png') }}"
                    alt="User Image" width="50" height="50" class="rounded-circle me-2">
                <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ route('admin.users.edit') }}">Profil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">Delogare</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
