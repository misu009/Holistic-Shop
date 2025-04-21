@extends('client.layout')

@section('title')
    {{ $product->name }} - {{ number_format($product->price, 0) }} LEI | {{ config('app.name') }}
@endsection

@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"> --}}

    <div class="container py-5">
        <div class="row d-flex">
            <!-- Product Media Carousel (col-4 on lg screens) -->
            <div class="col-lg-4">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if ($product->media->isEmpty())
                            <div class="carousel-item active text-center">
                                <p class="text-white fw-bold fs-2">no-media</p>
                            </div>
                        @endif
                        @foreach ($product->media as $key => $media)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="ratio ratio-1x1">
                                    @if (strpos($media->path, '.mp4') !== false)
                                        <a href="{{ asset('storage/' . $media->path) }}" class="glightbox">
                                            <video class="w-100 h-100" controls>
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                        {{-- <a href="{{ asset('storage/' . $media->path) }}" class="glightbox" data-type="video"
                                            data-gallery="product-gallery">
                                            <img src="{{ asset('images/your-placeholder.jpg') }}" alt="Video">
                                        </a> --}}
                                    @else
                                        <a href="{{ asset('storage/' . $media->path) }}" class="glightbox"
                                            data-gallery="product-gallery">
                                            <img src="{{ asset('storage/' . $media->path) }}"
                                                class="w-100 h-100 object-fit-cover" alt="Product Image">
                                        </a>
                                    @endif
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
            <div class="col-lg-8 d-flex flex-column text-white mt-lg-0 mt-4">
                <h1>{{ $product->name }}</h1>
                <h5 class="fw-bold">Descriere produs:</h5>
                <div id="productDescription">
                    {!! $product->description !!}
                </div>
            </div>


        </div>

        <!-- Description Overflow Section (Will move here if needed) -->
        <div class="row mt-4 d-none" id="descriptionOverflow">
            <div class="col-12 text-white">
                {{-- <h5 class="fw-bold">Descriere produs (continuare):</h5> --}}
                <div id="overflowContent"></div>
            </div>
        </div>

        <div class="container-fluid py-5 d-flex justify-content-center align-items-center flex-direction-column">
            <div class="container product-container text-white p-5 rounded-4 d-flex flex-column">
                <h2 class="text-uppercase fw-bold mb-4 text-center text-white">
                    Descoperă produse similare
                </h2>

                {{-- @dd($selectedProducts) --}}
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



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function adjustDescription() {
                let carouselHeight = document.querySelector("#productCarousel").offsetHeight;
                let description = document.querySelector("#productDescription");
                let overflowSection = document.querySelector("#descriptionOverflow");
                let overflowContent = document.querySelector("#overflowContent");

                if (description.offsetHeight > carouselHeight) {
                    overflowSection.classList.remove("d-none"); // Show overflow section

                    let text = description.innerHTML;
                    let words = text.split(" ");
                    console.log(words);
                    let visibleText = [];
                    let hiddenText = [];

                    let tempDiv = document.createElement("div");
                    tempDiv.style.visibility = "hidden";
                    tempDiv.style.position = "absolute";
                    tempDiv.style.width = description.clientWidth + "px";
                    document.body.appendChild(tempDiv);

                    for (let word of words) {
                        tempDiv.innerHTML += word + " ";
                        if (tempDiv.offsetHeight > carouselHeight) {
                            hiddenText.push(word);
                        } else {
                            visibleText.push(word);
                        }
                    }
                    document.body.removeChild(tempDiv);

                    description.innerHTML = visibleText.join(" ");
                    overflowContent.innerHTML = hiddenText.join(" ");
                } else {
                    overflowSection.classList.add("d-none"); // Hide overflow section
                }
            }

            adjustDescription();
            window.addEventListener("resize", adjustDescription);
        });
    </script>
@endsection
