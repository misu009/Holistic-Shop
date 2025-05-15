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
                <!-- Product Media Carousel (col-4 on lg screens) -->
                @php
                    $allMedia = $product->media;
                    if (isset($preview)) {
                        $allMedia = $mediaPreview;
                    }
                @endphp

                <div class="col-lg-4">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if (!count($allMedia))
                                <div class="carousel-item active text-center">
                                    <p class="text-white fw-bold fs-2">no-media</p>
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
                <div class="col-lg-8 d-flex flex-column text-white mt-lg-0 mt-4" id="productDescription">
                    <h1>{{ $product->name }}</h1>
                    <h5 class="fw-bold mt-5">Descriere produs:</h5>
                    <div class="fs-5">
                        {!! $product->description !!}
                    </div>
                    <div id="priceInfo">
                        <h3 class="fw-bold mt-4 text-white">{{ number_format($product->price, 2) }} LEI</h3>
                        <div class="text-white fs-5">
                            (pretul este orientativ, pentru mai multe informatii contactati-ne la
                            {{ $product->phone }}
                            @if ($product->email)
                                sau la {{ $product->email }}
                            @endif
                            )
                        </div>
                    </div>
                </div>


            </div>

            <div class="row mt-4 d-none text-white" id="descriptionOverflow">
                <div class="col-12 ">
                    <div id="overflowContent"></div>
                </div>
                <div>
                    <h3 class="fw-bold mt-4 text-white">{{ number_format($product->price, 2) }} LEI</h3>
                    <div class="text-white fs-5">
                        ( pretul este orientativ, pentru mai multe informatii contactati-ne la
                        {{ $product->phone }}
                        @if ($product->email)
                            sau la {{ $product->email }}
                        @endif
                        )
                    </div>
                </div>
            </div>

            <div class="container-fluid py-5 d-flex justify-content-center align-items-center flex-direction-column">
                <div class="container product-container text-white p-5 rounded-4 d-flex flex-column">
                    <h2 class="text-uppercase fw-bold mb-4 text-center text-white">
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
                                            <h5 class="mt-3 text-white">{{ $selectedProduct->name }}</h5>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function adjustDescription() {
                const carouselHeight = document.querySelector("#productCarousel").offsetHeight;
                const description = document.querySelector("#productDescription");
                const fullContentDiv = description.querySelector(".fs-5"); // Only description text
                const priceInfo = document.querySelector("#priceInfo");
                const overflowSection = document.querySelector("#descriptionOverflow");
                const overflowContent = document.querySelector("#overflowContent");

                // Reset state
                overflowSection.classList.add("d-none");
                priceInfo.classList.remove("d-none");
                fullContentDiv.innerHTML = fullContentDiv.dataset.full || fullContentDiv.innerHTML;
                overflowContent.innerHTML = "";

                // Save full content if not already saved
                if (!fullContentDiv.dataset.full) {
                    fullContentDiv.dataset.full = fullContentDiv.innerHTML;
                }

                // Create test container
                const tempDiv = document.createElement("div");
                tempDiv.style.visibility = "hidden";
                tempDiv.style.position = "absolute";
                tempDiv.style.width = fullContentDiv.offsetWidth + "px";
                tempDiv.style.fontSize = getComputedStyle(fullContentDiv).fontSize;
                document.body.appendChild(tempDiv);

                const words = fullContentDiv.dataset.full.split(" ");
                let low = 0,
                    high = words.length,
                    splitIndex = words.length;

                // Binary search for max visible text
                while (low <= high) {
                    let mid = Math.floor((low + high) / 2);
                    tempDiv.innerHTML = words.slice(0, mid).join(" ");
                    if (tempDiv.offsetHeight + priceInfo.offsetHeight <= carouselHeight) {
                        low = mid + 1;
                    } else {
                        splitIndex = mid;
                        high = mid - 1;
                    }
                }

                document.body.removeChild(tempDiv);

                if (splitIndex < words.length) {
                    fullContentDiv.innerHTML = words.slice(0, splitIndex).join(" ");
                    overflowContent.innerHTML = words.slice(splitIndex).join(" ");
                    overflowSection.classList.remove("d-none");
                    priceInfo.classList.add("d-none");
                }
            }

            adjustDescription();
            window.addEventListener("resize", adjustDescription);
        });
    </script>
@endsection
