@php
    $currLink = '/' . request()->path();
@endphp

<!-- Sidebar -->
<div id="sidebar" class="sidebar p-3">
    <div class="d-flex align-items-center mb-3">
        <i class="bi bi-bootstrap-fill text-white fs-2 me-2"></i>
        <h5 class="text-white mb-0">Lotus Retreat</h5>
    </div>
    <nav class="nav flex-column">
        @foreach ($links as $link)
            <a href="{{ $link['url'] }}"
                class="nav-link{{ $currLink == $link['url'] ? ' active' : '' }}">{{ $link['name'] }}</a>
        @endforeach
    </nav>
    <!-- User section at the bottom -->
    <div class="user-section p-3 text-white">
        <div class="d-flex align-items-center">
            <img src="{{ Storage::url(Auth::user()->picture) }}" alt="User photo" class="rounded-circle me-2"
                width="50" height="50">
            <span>{{ Auth::user()->name }}</span>
        </div>
    </div>
</div>
