@extends('client.layout')

@section('title', $category->name)

@section('content')
    <div id="shop-content" class="pt-5 mt-5">

        <div class="container text-center mb-5">
            <h1 class="text-black fw-bold display-4">{{ $category->name }}</h1>
            <p class="text-black fs-5 mx-auto" style="max-width: 800px;">
                {!! $category->description !!}
            </p>
            <a href="{{ route('client.shop.index') }}" class="btn btn-outline-dark mt-3">
                &larr; Inapoi la toate categoriile
            </a>
        </div>

        <x-client.divider />

        <div id="shop-product" class="mt-5 container">

            <div class="mb-5">
                <form action="{{ route('client.shop.category', $category->id) }}" method="GET"
                    class="d-flex justify-content-center align-items-center mt-4">
                    {{-- Added shadow-sm for depth --}}
                    <div class="input-group custom-search shadow-sm">
                        {{-- Removed 'text-light' so dark text shows on the white background --}}
                        <input type="text" name="query" class="form-control border-0 text-start bg-transparent"
                            placeholder="CAUTA IN {{ mb_strtoupper($category->name, 'UTF-8') }}"
                            value="{{ request('query') }}" aria-label="Search">
                        {{-- Removed 'text-light' --}}
                        <button type="submit" class="input-group-text bg-transparent border-0" aria-label="Submit search">
                            <i class="bi bi-search"></i> {{-- Changed icon to a standard search magnifying glass, optional! --}}
                        </button>
                    </div>
                </form>
            </div>

            <div class="shop-products row row-cols-2 row-cols-md-4 g-4 mt-2">
                @forelse ($products as $product)
                    <div class="col">
                        <div class="product-card-clean bg-white text-center p-3 h-100 d-flex flex-column shadow-sm">
                            <a href="{{ route('client.shop.show', ['slug' => $product->slug]) }}"
                                class="text-decoration-none text-black d-flex flex-column h-100">

                                <div class="product-image-container position-relative mb-3">
                                    <img class="product-image-fit img-fluid w-100"
                                        src="{{ $product->media->first() ? asset('storage/' . $product->media->first()->path) : asset('images/placeholder.png') }}"
                                        alt="{{ $product->name }}" loading="lazy" decoding="async">
                                </div>

                                <div class="flex-grow-1 d-flex flex-column mt-2">
                                    <h4 class="product-name fw-bold" style="color: #5b2b12;">{{ $product->name }}</h4>

                                    <p class="product-description small text-muted mt-1">
                                        {{ Str::words(strip_tags(html_entity_decode($product->excerpt ?? $product->short_description)), 12, ' ..') }}
                                    </p>
                                </div>

                                <div class="mt-auto pt-2">
                                    <h3 class="fw-bold mb-0">{{ number_format($product->price, 2) }} LEI</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center mt-5">
                        <h3 class="text-black">Nu am gasit produse in aceasta categorie.</h3>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5 mb-5">
                <x-client.pagination :paginator="$products" />
            </div>
        </div>
    </div>

    <style>
        /* --- Clean White Search Bar --- */
        .custom-search {
            /* Matched border to the golden card borders */
            border: 2px solid #e0c27b;
            border-radius: 8px;
            /* Slightly rounded edges */
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            /* Changed from Blue to White */
            transition: all 0.3s ease;
        }

        .custom-search:focus-within {
            border-color: #b96e2e;
            /* Darkens gold when typing */
            box-shadow: 0 4px 12px rgba(185, 110, 46, 0.15) !important;
        }

        .custom-search .form-control {
            background-color: transparent;
            color: #5b2b12;
            /* Dark golden/brown text */
            border: none;
            box-shadow: none;
            font-weight: 500;
        }

        .custom-search .form-control::placeholder {
            color: #b96e2e;
            opacity: 0.6;
        }

        .custom-search .input-group-text {
            color: #b96e2e;
            /* Golden icon */
            background: transparent;
            font-size: 1.2rem;
        }

        .custom-search button:hover i {
            color: #5b2b12;
            /* Icon gets darker on hover */
            cursor: pointer;
        }

        /* --- Clean White & Golden Card Styles for Products --- */
        .product-card-clean {
            border-radius: 15px;
            border: 1px solid #e0c27b;
            transition: all 0.3s ease;
        }

        .product-card-clean:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(185, 110, 46, 0.15) !important;
            border-color: #b96e2e;
        }

        /* --- Image Styles --- */
        .product-image-container {
            aspect-ratio: 1 / 1;
            width: 100%;
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

        .product-card-clean:hover .product-image-fit {
            transform: scale(1.05);
        }
    </style>
@endsection
