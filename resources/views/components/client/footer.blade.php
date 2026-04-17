<div class="bg-white border-top">
    <div class="container">
        <div class="row text-black pt-5 pb-5">
            <div
                class="col-md-4 col-12 d-flex flex-column align-items-center align-items-md-start text-center mb-4 mb-md-0">
                <div>
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/client/logo-footer.png') }}" alt="LOTUS RETREAT" style="width: 250px">
                    </a>
                </div>
                <div class="w-100 mt-4 fs-6 text-md-start text-center">
                    {!! $settings->footer_text ?? '' !!}
                </div>
            </div>

            <div class="col-md-4 col-12 d-flex flex-column align-items-center text-center mb-4 mb-md-0">
                <h5 class="fw-bold mb-3" style="color: #5b2b12;">MENIU PRINCIPAL</h5>
                <a class="text-decoration-none text-black mb-2" href="{{ route('home') }}">ACASA</a>
                <a class="text-decoration-none text-black mb-2" href="{{ route('client.posts.index') }}">BLOG</a>
                <a class="text-decoration-none text-black mb-2" href="{{ route('client.shop.index') }}">SHOP</a>
                <a class="text-decoration-none text-black mb-2" href="{{ route('client.collaborators.index') }}">ECHIPA
                    NOASTRA</a>
                <a class="d-sm-block d-none text-decoration-none text-black mb-2"
                    href="{{ route('client.events.index') }}">EVENIMENTE</a>
                <a class="d-sm-block d-none text-decoration-none text-black mb-2"
                    href="{{ route('client.contact.index') }}">CONTACT</a>
            </div>

            <div class="col-md-4 col-12 d-flex flex-column align-items-center align-items-md-end text-center">
                <h5 class="fw-bold mb-3" style="color: #5b2b12;">INFORMAȚII UTILE</h5>

                {{-- Loop through the dynamic pages sent from the AppServiceProvider --}}
                @isset($footerPages)
                    @foreach ($footerPages as $page)
                        <a class="text-decoration-none text-black mb-2"
                            href="{{ route('client.pages.show', $page->slug) }}">
                            {{ mb_strtoupper($page->title) }}
                        </a>
                    @endforeach
                @endisset

                {{-- Follow Us link at the bottom of the useful info --}}
                <a class="text-decoration-none text-black mt-3 fw-bold"
                    href="{{ $settings->footer_follow_us ?? '#' }}">
                    FOLLOW US
                </a>
            </div>
        </div>
    </div>
</div>
