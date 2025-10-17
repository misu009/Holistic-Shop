@extends('client.layout')

@section('title', 'Holistic Shop')

@section('content')
    <div class="homepage">
        <div class="hero-section  fade show">
            <div class="hero-content h-100 text-left text-black d-flex flex-column align-items-center">
                <h1 class="text-left col-md-7 col-9 mb-4" style="margin-top: 48vh;">{{ $settings->hero_text_1 }}</h1>
                <h4 class="text-left col-md-7 pe-5 col-9 mb-4 mt-2">{{ $settings->hero_text_2 }}</h4>
                <h4 class="text-left col-md-7 col-9 mb-4 mt-2">{{ $settings->hero_text_3 }}</h4>
            </div>
        </div>

        <x-client.divider />

        <div class="our-mision fade-in pb-5">
            <div class="container our-mision-content d-flex flex-column">
                <div class="our-mision-texts p-5 w-100 d-flex align-items-center flex-column">
                    <h2 class="our-mision-title text-center" style="letter-spacing: 2px">MISIUNEA NOASTRA</h2>
                    <p class="mt-3 text-center fs-5">
                        {{ $settings->mission_text }}
                    </p>
                </div>
                <div class="container fade-in" style="flex: 1">
                    <div class="row align-items-center h-100">
                        <div class="d-md-block d-none col-md-4 text-end col-6" style="height: inherit">
                            <ul class="info-list-left p-1 d-flex align-items-end justify-content-around"
                                style="height: inherit; flex-direction: column;">
                                @if ($settings->mission_bullets)
                                    @foreach ($settings->mission_bullets as $index => $mission_bullet)
                                        @if ($loop->index % 2 == 0)
                                            <li class="fs-5 mt-5">
                                                {{ $mission_bullet }}</li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="d-none d-md-block col-md-4"></div>
                        <div class="d-md-block d-none col-6 col-md-4 text-start p-1" style="height: inherit">
                            <ul class="info-list d-flex justify-content-around align-items-start"
                                style="height: inherit; flex-direction: column;">
                                @if ($settings->mission_bullets)
                                    @foreach ($settings->mission_bullets as $index => $mission_bullet)
                                        @if ($loop->index % 2 == 1)
                                            <li class="our-mission-text mt-5">
                                                {{ $mission_bullet }}</li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container fade-in">
                    <div class="row">
                        <div class="d-block d-md-none text-start">
                            <ul class="info-list d-flex flex-wrap list-unstyled">
                                @if ($settings->mission_bullets)
                                    @foreach ($settings->mission_bullets as $mission_bullet)
                                        <li class="w-50 p-2 fs-5 mt-5">
                                            {{ $mission_bullet }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-client.divider />

        <div class="product-section d-flex  align-items-stretch flex-column">
            <div class="banner-wrapper">
                <img src="{{ asset('images/client/banner-shop.png') }}" alt="shop banner">
            </div>
            <div class="p-5 d-flex flex-grow-1 justify-content-center container text-black  rounded-4 d-flex flex-column">
                <h2 class="text-uppercase fw-bold mb-4 text-center">
                    <a href="{{ route('client.shop.index') }}" class="text-black text-decoration-none">
                        Descoperă Produse
                    </a>
                </h2>

                @php
                    if ($settings->selected_products != null) {
                        $selectedProducts = \App\Models\Product::whereIn('id', $settings->selected_products)
                            ->take(4)
                            ->get();
                    } else {
                        $selectedProducts = \App\Models\Product::take(4)->get();
                    }
                @endphp

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 text-center mt-4">
                    @foreach ($selectedProducts as $product)
                        <div class="col d-flex">
                            <a href="{{ route('client.shop.show', ['slug' => $product->slug]) }}"
                                class="text-decoration-none w-100">
                                <div class="card my-gradient-card border-0 bg-transparent d-flex flex-column h-100">
                                    <div class="position-relative">
                                        <img class="img-fluid w-100"
                                            src="{{ !empty($product->media) && isset($product->media[0]) ? asset('storage/' . $product->media[0]->path) : asset('images/client/product-' . ($loop->index + 1) . '.png') }}"
                                            alt="Product Image"
                                            style="aspect-ratio: 1/1; object-fit: cover; border-radius: 15px;">
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-end">
                                        <h5 class="mt-3">{{ $product->name }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <p class="text-center mt-4">
                    Orice produs se creeaza personalizat pe vibratia si energia fiecaruia
                </p>
            </div>
        </div>

        <x-client.divider />

        <div class="about-us">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-7 col-12 about-us-images d-flex justify-content-center align-items-center">
                        <img src="{{ asset('images/client/cine_suntem_noi_1.png') }}" alt="">
                    </div>
                    <div
                        class="about-us-content my-gradient-card col-md-5 col-12 p-5 flex-column text-black d-flex justify-content-center align-items-start">
                        <h2>CINE SUNTEM NOI?!</h2>
                        <div class="mt-5 fs-4">
                            <p>{!! $settings->about_text !!}</p>
                        </div>
                        <a class="btn btn-custom mt-5 text-decoration-none text-white"
                            href="{{ route('client.posts.index') }}">
                            CITEȘTE MAI MULTE PE BLOG
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <x-client.divider />

        @php
            $selectedPosts = \App\Models\Post::whereIn('id', $settings->selected_blog_posts)->take(3)->get();
        @endphp

        <div id="blog-home">
            <div class="container py-5">
                {{-- First Row --}}
                <div class="row g-4 align-items-stretch">
                    {{-- Left (larger) post --}}
                    <div class="col-8">
                        @if (isset($selectedPosts[0]))
                            <x-client.post-card :post="$selectedPosts[0]" />
                        @endif
                    </div>


                    <div class="col-4 d-flex">
                        @if (isset($selectedPosts[1]))
                            <x-client.post-card :post="$selectedPosts[1]" aspect="4/3" class="h-100 w-100" />
                        @endif
                    </div>
                </div>

                <div class="row g-4 mt-4">
                    <div class="col-6">
                        @if (isset($selectedPosts[2]))
                            <x-client.post-card :post="$selectedPosts[2]" aspect="4/3" class="h-100" />
                        @endif
                    </div>

                    <div class="col-6">
                        <a href="{{ route('client.posts.index') }}" class="blog-wrapper border-golden">
                            <div class="ratio-box" style="aspect-ratio: 4 / 3;">
                                <img src="{{ asset('images/client/image-4.png') }}" alt="Blog" class="blog-image">
                                <div class="blog-overlay"></div>
                                {{-- <div class="blog-content fs-1 text-black">VEZI TOATE <br> ARTICOLELE <br> DE PE BLOG
                                </div> --}}
                                <div class="d-md-block d-none blog-content fs-1 text-black">VEZI TOATE <br> ARTICOLELE <br>
                                    DE PE BLOG
                                </div>
                                <div class="d-md-none d-block blog-content fs-5 text-black">VEZI TOATE <br> ARTICOLELE <br>
                                    DE PE BLOG
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function checkInView() {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(function(element) {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                const windowTop = window.scrollY;
                const windowBottom = windowTop + window.innerHeight;

                if (elementBottom >= windowTop && elementTop <= windowBottom) {
                    element.classList.add('visible');
                }
            });
        }

        window.addEventListener('scroll', checkInView);
        checkInView();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aboutUs = document.querySelector('.about-us');

        function checkVisibility() {
            const rect = aboutUs.getBoundingClientRect();
            const windowHeight = window.innerHeight;

            // Check if the element is in the viewport
            if (rect.top <= windowHeight && rect.bottom >= 0) {
                aboutUs.style.opacity = 1;
                aboutUs.style.transform = 'translateY(0)';
            }
        }

        // Trigger checkVisibility on scroll and page load
        window.addEventListener('scroll', checkVisibility);
        checkVisibility(); // Check on page load in case it's already in view
    });
</script>
