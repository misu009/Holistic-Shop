@extends('client.layout')

@section('title', 'Shop')

@section('content')
    <section class="hero-shop-section">
        <div class="container p-4 d-flex flex-column justify-content-md-around" style="height: inherit">
            <div class="hero-shop-content d-md-block d-flex flex-column justify-content-between">
                <div>
                    <div class="text-md-start text-center text-black fs-1">
                        {!! $settings->shop_text_1 !!}
                    </div>
                </div>
                <div class="mt-5">
                    <div class="text-md-start text-center text-black fs-1 pb-5">
                        {!! $settings->shop_text_2 !!}
                    </div>

                    <a href="#unique-orgonites"
                        class="d-md-none ms-auto me-auto d-block hero-shop-button text-decoration-none text-black">{{ $settings->shop_text_3 }}</a>
                </div>
            </div>
            <a href="#unique-orgonites"
                class="d-none d-md-block hero-shop-button text-decoration-none text-black">{{ $settings->shop_text_3 }}</a>
        </div>
    </section>

    <x-client.divider />

    <div id="shop-content" class="pt-5">
        <div id="unique-orgonites" class="mb-5">
            <div class="container">
                <h2 class="text-black text-center fs-1">Vindeca-ti energia</h2>
                <div class="row">
                    @foreach (range(1, 4) as $i)
                        @php
                            $field = 'shop_img_' . $i;
                            $imagePath = $settings->$field ?? null;
                        @endphp

                        <div class="col-md-3 col-6 mt-3 d-flex justify-content-center">
                            <img class="img-uniques-orgonites"
                                src="{{ $imagePath ? Storage::url($imagePath) : asset('images/client/shop-' . $i . '.png') }}"
                                alt="Shop {{ $i }}" loading="lazy" decoding="async">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="shop-categories" class="mt-5 container mb-5">
            <h1 class="text-black text-center mb-5">
                Descopera Categoriile Noastre
            </h1>

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                @foreach ($categories as $category)
                    <div class="col">
                        {{-- CLEAN WHITE & GOLDEN CARD --}}
                        <div class="category-card-clean bg-white text-center p-4 h-100 d-flex flex-column shadow-sm">
                            <a href="{{ route('client.shop.category', ['id' => $category->id]) }}"
                                class="text-decoration-none text-black d-flex flex-column h-100">

                                <div class="product-image-container mb-3">
                                    <img class="product-image-fit img-fluid w-100"
                                        src="{{ $category->picture ? asset('storage/' . $category->picture) : asset('images/placeholder.png') }}"
                                        alt="{{ $category->name }}" loading="lazy" decoding="async">
                                </div>

                                <div class="flex-grow-1 mt-2">
                                    {{-- Uses a dark golden/brown hue for the title --}}
                                    <h3 class="fw-bold" style="color: #5b2b12;">{{ $category->name }}</h3>
                                    <p class="small text-muted mt-2">
                                        {{ Str::words(strip_tags(html_entity_decode($category->description)), 15, ' ..') }}
                                    </p>
                                </div>

                                <div class="mt-auto pt-3">
                                    {{-- Using your exact golden button class --}}
                                    <span class="btn btn-custom w-100">Vezi Produsele</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                <x-client.pagination :paginator="$categories" />
            </div>
        </div>
    </div>

    <style>
        /* --- Clean White & Golden Card Styles --- */
        .category-card-clean {
            border-radius: 15px;
            /* A subtle golden border outline */
            border: 1px solid #e0c27b;
            transition: all 0.3s ease;
        }

        .category-card-clean:hover {
            transform: translateY(-8px);
            /* Soft golden glowing shadow on hover */
            box-shadow: 0 15px 25px rgba(185, 110, 46, 0.15) !important;
            /* Border gets darker gold on hover */
            border-color: #b96e2e;
        }

        /* --- Image Styles --- */
        .product-image-container {
            aspect-ratio: 1 / 1;
            width: 100%;
            /* Very light grey background for the image holding area */
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-image-fit {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.5s ease;
        }

        /* Subtle zoom effect on the image when hovering over the card */
        .category-card-clean:hover .product-image-fit {
            transform: scale(1.05);
        }
    </style>
@endsection
