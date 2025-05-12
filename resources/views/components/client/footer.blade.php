<div class="container">
    <div class="row text-white pt-2 pb-2">
        <div class="col-sm-6 col-12 d-flex flex-column align-items-center align-items-md-start text-center">
            <div>
                <a href="{{ route('home') }}"><img src="{{ asset('images/client/logo-footer.png') }}"
                        alt="LOTUS RETREAT"></a>
            </div>
            <div class="w-lg-50 mt-4 fs-5">
                {!! $settings->footer_text ?? '' !!}</div>
        </div>
        <div class="col-sm-6 col-12 d-flex flex-column align-items-center align-items-md-end text-center">
            <a class="d-block text-decoration-none text-white mt-3" href="{{ route('home') }}">
                ACASA
            </a>
            <a class="d-block text-decoration-none text-white mt-3" href="{{ route('client.posts.index') }}">
                BLOG
            </a>
            <a class="d-block text-decoration-none text-white mt-3" href="{{ route('client.shop.index') }}">
                SHOP
            </a>
            <a class="d-block text-decoration-none text-white mt-3" href="{{ route('client.collaborators.index') }}">
                ECHIPA NOASTRA
            </a>
            <a class="d-sm-block d-none text-decoration-none text-white mt-3" href="{{ route('client.events.index') }}">
                EVENIMENTE
            </a>
            <a class="d-sm-block d-none text-decoration-none text-white mt-3"
                href="{{ route('client.contact.index') }}">
                CONTACT
            </a>
            <a class="d-block text-decoration-none text-white mt-3 mb-3" href="{{ $settings->footer_follow_us }}">
                FOLLOW US
            </a>
        </div>
    </div>
</div>
