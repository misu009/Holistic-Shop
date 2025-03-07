@extends('client.layout')

@section('title', 'Holistic Shop')

@section('content')
    <div class="homepage">
        <div class="hero-section  fade show">
            <div class="hero-left">
                <div class="rounded-container">
                    <div class="d-flex">
                        <p class="text-white mt-5 hero-text-1">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.
                            Sapiente harum totam autem
                            sit recusandae quas temporibus voluptas voluptates nulla nisi.</p>
                        <img height="220px" class="hero-lotus" src="{{ asset('images/client/ellipse-hero.svg') }}"
                            alt="">
                    </div>
                    <div>
                        <p class="hero-text-2">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit aut nam asperiores odio natus fuga.
                        </p>
                    </div>
                </div>
            </div>
            <div class="hero-right"></div>
        </div>

        <div class="our-mision mt-5 fade-in">
            <div class="our-mision-texts p-5 w-100 d-flex align-items-center contianer" style="flex-direction: column">
                <h2 class="our-mision-title" style="letter-spacing: 2px">MISIUNEA NOASTRA</h2>
                <p class="mt-3" style="font-size: 13px; text-align: center;">
                    {{ $settings->mission_text }}
                </p>
            </div>
            <div class="our-mision-content container fade-in">
                <div class="row align-items-center" style="height: inherit">
                    <div class="d-md-block d-none col-md-4 text-end col-6" style="height: inherit">
                        <ul class="info-list-left p-1 d-flex align-items-center justify-content-around"
                            style="height: inherit; flex-direction: column;">
                            @foreach ($settings->mission_bullets as $index => $mission_bullet)
                                @if ($loop->index % 2 == 0)
                                    <li>{{ $mission_bullet }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-none d-md-block col-md-4"></div>
                    <div class="d-md-block d-none col-6 col-md-4 text-start p-1" style="height: inherit">
                        <ul class="info-list d-flex justify-content-around align-items-center"
                            style="height: inherit; flex-direction: column;">
                            @foreach ($settings->mission_bullets as $index => $mission_bullet)
                                @if ($loop->index % 2 == 1)
                                    <li>{{ $mission_bullet }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container fade-in">
                <div class="row">
                    <div class="d-block d-md-none text-start">
                        <ul class="info-list d-flex flex-wrap list-unstyled">
                            @foreach ($settings->mission_bullets as $mission_bullet)
                                <li class="w-50 p-2">{{ $mission_bullet }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-us">
            <div class="row about-us-content">
                <div class="col-md-7 col-12 about-us-images d-flex justify-content-center align-items-center">
                    <img src="{{ asset('images/client/about-us-clj.svg') }}" alt="">
                </div>
                <div class="col-md-5 col-12 p-5 flex-column text-white d-flex justify-content-center align-items-start">
                    <h2>CINE SUNTEM NOI?!</h2>
                    <div class="mt-5 scrollable-paragraph">
                        <p>{{ $settings->about_text }}</p>
                    </div>
                    <button class="btn btn-custom mt-5">CITEȘTE MAI MULTE PE BLOG</button>
                </div>
            </div>
        </div>
        <div class="blog-section">
            <div class="container mt-4 mb-4" style="overflow: hidden">
                @php
                    $selectedPosts = \App\Models\Post::whereIn('id', $settings->selected_blog_posts)->take(3)->get();
                @endphp

                <div class="d-flex justify-content-center align-items-center mb-3 blog-images-1">
                    @foreach ($selectedPosts->take(2) as $post)
                        <a href="#" class="" style="height: inherit">
                            <div class="image-box me-3" @if ($loop->first) style="width: 40vw;" @endif>
                                <img src="{{ !empty($post->media) && isset($post->media[0]) ? asset('storage/' . $post->media[0]->path) : asset('images/client/image-' . ($loop->index + 1) . '.png') }}"
                                    alt="Post Image">
                                <p class="text-white d-md-block d-none">{{ $post->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center align-items-center blog-images-2">
                    @if ($selectedPosts->count() >= 3)
                        @php $thirdPost = $selectedPosts[2]; @endphp
                        <a href="#" class="" style="height: inherit">
                            <div class="image-box me-3">
                                <img src="{{ !empty($thirdPost->media) && isset($thirdPost->media[0]) ? asset('storage/' . $thirdPost->media[0]->path) : asset('images/client/image-3.png') }}"
                                    alt="Post Image">
                                <p class="text-white d-md-block d-none">{{ $thirdPost->title }}</p>
                            </div>
                        </a>
                    @else
                        <a href="#" class="" style="height: inherit">
                            <div class="image-box me-3">
                                <img src="{{ asset('images/client/image-3.png') }}" alt="">
                                <p class="text-white d-md-block d-none">Lorem, ipsum dolor.</p>
                            </div>
                        </a>
                    @endif
                    <a href="#" class="" style="height: inherit">
                        <div class="image-box">
                            <img src="{{ asset('images/client/image-4.png') }}" alt="">
                            <h1 class="text-white">Vezi toate articolele pe blog</h1>
                        </div>
                    </a>
                </div>


            </div>
        </div>

        <div
            class="container-fluid product-section py-5 d-flex justify-content-center align-items-center flex-direction-column">
            <div class="container product-container text-white p-5 rounded-4 d-flex flex-column">
                <h2 class="text-uppercase fw-bold mb-4 text-center">
                    <a href="#" class="text-decoration-none">
                        Descoperă Produse
                    </a>
                </h2>

                @php
                    $selectedProducts = \App\Models\Product::whereIn('id', $settings->selected_products)
                        ->take(4)
                        ->get();
                @endphp

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 text-center">
                    @foreach ($selectedProducts as $product)
                        <div class="col d-flex">
                            <a href="#" class="text-decoration-none w-100 h-100">
                                <div class="card my-gradient-card border-0 bg-transparent d-flex flex-column h-100">
                                    <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                                        <img class="img-fluid h-100 w-100"
                                            src="{{ !empty($product->media) && isset($product->media[0]) ? asset('storage/' . $product->media[0]->path) : asset('images/client/image-' . ($loop->index + 1) . '.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="mt-3 text-white">{{ $product->name }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <p class="text-center mt-4">
                    Office ipsum you must be muted. Hill join social harvest old protocol need emails spaces not.
                </p>
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
