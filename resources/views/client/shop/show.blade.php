@extends('client.layout')

@section('title')
    {{ $product->name }} - {{ number_format($product->price, 0) }} LEI | {{ config('app.name') }}
@endsection

@section('content')
    <section id="product-show" class="fs-5">
        <div class="container py-5">
            <div class="row d-flex">
                @if (isset($preview))
                    <h1 class="text-danger text-center mb-5">!!Acesta este doar un preview!! Produsul nu a fost salvat inca
                    </h1>
                @endif

                @php
                    $allMedia = $product->media;
                    if (isset($preview)) {
                        $allMedia = $mediaPreview;
                    }
                @endphp

                <!-- Carousel -->
                <div class="col-lg-4">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if (!count($allMedia))
                                <div class="carousel-item active text-center">
                                    <p class="text-black fw-bold fs-2">no-media</p>
                                </div>
                            @endif

                            @foreach ($allMedia as $key => $media)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <div class="ratio ratio-1x1">
                                        <a href="{{ asset('storage/' . $media->path) }}" class="glightbox"
                                            data-gallery="product-gallery"
                                            data-type="{{ Str::endsWith($media->path, ['.mp4', '.webm']) ? 'video' : 'image' }}">
                                            @if (Str::endsWith($media->path, ['.mp4', '.webm']))
                                                <video class="w-100 h-100 object-fit-cover" muted>
                                                    <source src="{{ asset('storage/' . $media->path) }}">
                                                </video>
                                            @else
                                                <img src="{{ asset('storage/' . $media->path) }}"
                                                    class="w-100 h-100 object-fit-cover" alt="">
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

                <!-- Product Description (col-8 on lg screens) -->
                <div class="col-lg-8 d-flex flex-column text-black mt-lg-0 mt-4" id="productDescription">

                    <!-- Add to Cart moved to the START of this column -->
                    <div class="text-black fs-5 mb-4" id="priceInfo">
                        <form action="{{ route('client.cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-stretch gap-3">
                                <div class="d-flex align-items-center justify-content-center px-3 rounded">
                                    <h3 class="fw-bold text-black m-0">{{ number_format($product->price, 2) }} LEI</h3>
                                </div>
                                <button type="submit"
                                    class="btn btn-custom d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>

                    <h1>{{ $product->name }}</h1>
                    <h5 class="fw-bold mt-3">Descriere produs:</h5>

                    <!-- Description content (we keep the full HTML here and the script will split it) -->
                    <div class="fs-5" id="fullDescription">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>

            <!-- Overflow area (below the carousel). Only used when JS determines there's more content than fits) -->
            <div class="row mt-4 d-none text-black" id="descriptionOverflow">
                <div class="col-12">
                    <div id="overflowContent"></div>
                </div>
            </div>

            <!-- Similar products -->
            <div class="container-fluid py-5 d-flex justify-content-center align-items-center flex-direction-column">
                <div class="container product-container text-black p-5 rounded-4 d-flex flex-column">
                    <h2 class="text-uppercase fw-bold mb-4 text-center text-black">
                        Descoperă produse similare
                    </h2>
                    <div class="row mt-4 row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 text-center">
                        @foreach ($selectedProducts as $selectedProduct)
                            <div class="col d-flex">
                                <a href="{{ route('client.shop.show', ['slug' => $selectedProduct->slug]) }}"
                                    class="text-decoration-none w-100">
                                    <div class="card my-gradient-card border-0 bg-transparent d-flex flex-column h-100">
                                        <div class="position-relative">
                                            <img class="img-fluid w-100"
                                                src="{{ !empty($selectedProduct->media) && isset($selectedProduct->media[0]) ? asset('storage/' . $selectedProduct->media[0]->path) : '' }}"
                                                alt="Selected Product Image"
                                                style="aspect-ratio: 1/1; object-fit: cover; border-radius: 15px;">
                                        </div>
                                        <div class="card-body d-flex flex-column justify-content-end">
                                            <h5 class="mt-3 text-black">{{ $selectedProduct->name }}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Splitting JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const BREAKPOINT_LG = 992; // Bootstrap lg breakpoint

            function adjustDescription() {
                const carousel = document.querySelector("#productCarousel");
                const carouselHeight = carousel ? carousel.offsetHeight : 0;
                const fullContentDiv = document.querySelector("#fullDescription");
                const priceInfo = document.querySelector("#priceInfo");
                const overflowSection = document.querySelector("#descriptionOverflow");
                const overflowContent = document.querySelector("#overflowContent");

                if (!fullContentDiv) return;

                // Reset overflow visibility & content
                overflowSection.classList.add("d-none");
                overflowContent.innerHTML = "";

                // Cache original full HTML the first time
                if (!fullContentDiv.dataset.full) {
                    fullContentDiv.dataset.full = fullContentDiv.innerHTML;
                }
                // Restore full content before re-calculating
                fullContentDiv.innerHTML = fullContentDiv.dataset.full;

                // Only perform splitting on large screens (when carousel is beside description)
                if (window.innerWidth < BREAKPOINT_LG || !carousel) {
                    // Small screens: leave everything under the carousel
                    return;
                }

                const priceHeight = priceInfo ? priceInfo.offsetHeight : 0;
                const availableHeight = Math.max(0, carouselHeight - priceHeight);

                // Create a hidden measuring container with identical width and text metrics
                const tempVisible = document.createElement("div");
                tempVisible.style.visibility = "hidden";
                tempVisible.style.position = "absolute";
                tempVisible.style.left = "-9999px";
                tempVisible.style.top = "0";
                tempVisible.style.width = fullContentDiv.offsetWidth + "px";

                // Copy basic text metrics to match the layout
                const cs = getComputedStyle(fullContentDiv);
                tempVisible.style.fontSize = cs.fontSize;
                tempVisible.style.lineHeight = cs.lineHeight;
                tempVisible.style.fontFamily = cs.fontFamily;
                tempVisible.style.whiteSpace = "normal";
                document.body.appendChild(tempVisible);

                // Parse original HTML into nodes (so we can keep whole nodes intact)
                const parser = new DOMParser();
                const doc = parser.parseFromString(fullContentDiv.dataset.full, "text/html");
                const nodes = Array.from(doc.body.childNodes);

                // Append nodes one by one until we overflow
                let splitIndex = nodes.length;
                for (let i = 0; i < nodes.length; i++) {
                    tempVisible.appendChild(nodes[i].cloneNode(true));
                    if (tempVisible.offsetHeight > availableHeight) {
                        splitIndex = i;
                        break;
                    }
                }

                document.body.removeChild(tempVisible);

                // If everything fits -> nothing to overflow
                if (splitIndex === nodes.length) {
                    return;
                }

                // Build visible and hidden HTML preserving whole nodes
                const visibleHTML = nodes.slice(0, splitIndex).map(el => el.outerHTML || el.textContent).join("");
                const hiddenHTML = nodes.slice(splitIndex).map(el => el.outerHTML || el.textContent).join("");

                fullContentDiv.innerHTML = visibleHTML;

                if (hiddenHTML.trim().length > 0) {
                    overflowContent.innerHTML = hiddenHTML;
                    overflowSection.classList.remove("d-none");
                    // priceInfo remains visible at the top of the description column
                }
            }

            // Run initially and on resize (debounced)
            adjustDescription();
            let resizeTimer = null;
            window.addEventListener("resize", function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(adjustDescription, 120);
            });

            // If carousel changes height (images loaded late), re-run after a short delay
            // Useful when carousel images load asynchronously
            window.addEventListener('load', function() {
                setTimeout(adjustDescription, 120);
            });
        });
    </script>

    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }

        /* Optional helper to ensure measurement matches content */
        #fullDescription,
        #overflowContent {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
    </style>
@endsection
