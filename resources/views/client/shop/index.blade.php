@extends('client.layout')

@section('title', 'Shop')

@section('content')
    <section class="hero-shop-section">
        <div class="container p-4 d-flex flex-column justify-content-md-around" style="height: inherit">
            <div class="hero-shop-content d-md-block d-flex flex-column justify-content-between">
                <div>
                    <div class="text-md-start text-center text-white fs-1">
                        {!! $settings->shop_text_1 !!}
                    </div>
                </div>
                <br>
                <br>
                <div>
                    <div class="text-md-start text-center text-white fs-1 pb-5">
                        {!! $settings->shop_text_2 !!}
                    </div>

                    <a href="#unique-orgonites"
                        class="d-md-none ms-auto me-auto d-block hero-shop-button text-decoration-none">{{ $settings->shop_text_3 }}</a>
                </div>
            </div>
            <a href="#unique-orgonites"
                class="d-none d-md-block hero-shop-button text-decoration-none">{{ $settings->shop_text_3 }}</a>
        </div>
    </section>
    <div id="shop-content" class="pt-5">
        <div id="unique-orgonites" class="mb-5">
            <div class="container">
                <h2 class="text-white text-center fs-1">Vindeca-ti energia</h2>
                <div class="row">
                    @foreach (range(1, 4) as $i)
                        @php
                            $field = 'shop_img_' . $i;
                            $imagePath = $settings->$field ?? null;
                        @endphp

                        <div class="col-md-3 col-6 mt-3 d-flex justify-content-center">
                            <img class="img-uniques-orgonites"
                                src="{{ $imagePath ? Storage::url($imagePath) : asset('images/client/shop-' . $i . '.png') }}"
                                alt="Shop {{ $i }}">
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
        <div id="shop-product" class="mt-5 container">
            <h1 class="text-white text-center mb-4">
                Descopera produsele noastre
            </h1>
            <div class="shop-products row row-cols-2 row-cols-md-4 g-4 mt-2">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="shop-product text-center text-white p-3 h-100 d-flex flex-column">
                            <a href="{{ route('client.shop.show', ['slug' => $product->slug]) }}"
                                class="text-decoration-none text-white">
                                <div class="product-image position-relative">
                                    <img class="img-fluid w-100"
                                        src="{{ !empty($product->media) && isset($product->media[0]) ? asset('storage/' . $product->media[0]->path) : '' }}"
                                        alt="{{ $product->name }}">
                                </div>

                                <div class="mt-3 flex-grow-1">
                                    {{-- <h4 class="product-name fw-bold">{{ $product->name }}</h4> --}}
                                    <p class="product-description " st>
                                        {{ Str::words(strip_tags(html_entity_decode($product->description)), 5, ' ..') }}
                                    </p>
                                </div>

                                <h3 class="fw-bold">{{ number_format($product->price, 2) }} LEI</h3>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                <x-client.pagination :paginator="$products" />
            </div>
        </div>
    </div>
@endsection
