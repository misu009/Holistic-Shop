@extends('client.layout')

@section('title', 'Holistic Shop')

@section('content')
    <div class="homepage">
        <div class="hero-section">
            <div class="hero-left">
                <div class="rounded-container">
                    <div class="d-flex">
                        <p class="text-white mt-5 hero-text-1">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.
                            Sapiente harum totam autem
                            sit recusandae quas temporibus voluptas voluptates nulla nisi.</p>
                        <img class="hero-lotus" src="{{ asset('images/client/hero-img-2.png') }}" alt="">
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

        <div class="our-mision mt-5">
            <div class="our-mision-texts p-5 w-100 d-flex align-items-center contianer" style="flex-direction: column">
                <h2 class="our-mision-title" style="letter-spacing: 2px">MISIUNEA NOASTRA</h2>
                <p class="mt-3" style="font-size: 13px; text-align: center;">Lorem ipsum dolor sit amet consectetur
                    adipisicing elit.
                    Ducimus itaque adipisci
                    veritatis laudantium sequi porro ex corporis officia placeat maxime?</p>
            </div>
            <div class="our-mision-content container">
                <div class="row align-items-center " style="height: inherit">
                    <div class="d-md-block d-none col-md-4 text-end col-6" style="height: inherit">
                        <ul class="info-list-left p-1 d-flex align-items-center justify-content-around"
                            style="height: inherit; flex-direction: column;">
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="d-none d-md-block col-md-4"></div>
                    <div class="d-md-block d-none col-6 col-md-4 text-start p-1" style="height: inherit">
                        <ul class="info-list d-flex justify-content-around align-items-center"
                            style="height: inherit; flex-direction: column;">
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos
                                sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos
                                sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos
                                sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                            <li>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos
                                sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="d-block d-md-none text-start">
                        <ul class="info-list d-flex flex-wrap list-unstyled">
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure! <span class="circle"></span>
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                            <li class="w-50 p-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos sapiente praesentium quam
                                distinctio, quisquam nam soluta reiciendis corrupti atque iure!
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-us">
            <div class="row about-us-content">
                <div class="col-md-7 col-12 about-us-images" style="">
                    <img src="{{ asset('images/client/about-us/about-us-1.png') }}" class="image-about-us image-about-us-1"
                        alt="">
                    <img src="{{ asset('images/client/about-us/about-us-2.png') }}" class="image-about-us image-about-us-2"
                        alt="">
                    <img src="{{ asset('images/client/about-us/about-us-3.png') }}" class="image-about-us image-about-us-3"
                        alt="">
                    <img src="{{ asset('images/client/about-us/about-us-4.png') }}" class="image-about-us image-about-us-4"
                        alt="">
                    <img src="{{ asset('images/client/about-us/about-us-5.png') }}" class="image-about-us image-about-us-5"
                        alt="">
                </div>
                <div class="col-md-5 col-12 p-5 flex-column text-white d-flex justify-content-center align-items-start">
                    <h2>CINE SUNTEM NOI?!</h2>
                    <div class="mt-5 scrollable-paragraph">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, delectus impedit provident
                            quia ipsa excepturi ullam repellat deserunt aliquam cumque, odit officiis modi culpa.
                            Corporis rem eum magnam eveniet, nulla facilis porro, voluptas repellendus deserunt
                            explicabo repellat est voluptatum nostrum illo totam asperiores? Assumenda dolores, enim et
                            incidunt aut, rem consectetur nostrum ipsum autem omnis veritatis ipsam eum harum distinctio
                            facere, provident vitae? Autem dignissimos voluptas blanditiis modi quasi, id nihil sunt nam
                            maiores temporibus iure officia, nobis ea, iste perspiciatis iusto. Est ad veniam omnis
                            corrupti voluptatum tempore atque dignissimos laudantium, asperiores impedit quis, iusto
                            numquam similique possimus. Sunt debitis labore ullam sequi id laudantium ipsam vel,
                            excepturi quibusdam saepe minima provident animi? Ut blanditiis similique iusto eligendi
                            temporibus quisquam nihil dolorem cum laudantium aspernatur iure nemo, totam non velit eaque
                            praesentium? Obcaecati aliquam, itaque magni error consequatur ut quos veniam at odit illum
                            hic similique consequuntur. Nobis saepe harum maiores aut voluptates enim, voluptas possimus
                            alias temporibus. A exercitationem vel necessitatibus numquam totam ex laboriosam culpa hic!
                            In, natus? Ex unde eos temporibus dolor voluptatem mollitia qui. Quia mollitia ratione rerum
                            error sunt praesentium? Nostrum, facere? Optio atque vel magni fuga doloribus voluptates
                            sapiente eligendi hic molestias modi.
                        </p>
                    </div>
                    <button class="btn btn-custom mt-5">CITEȘTE MAI MULTE PE BLOG</button>
                </div>
            </div>
        </div>

        <div class="blog-section">
            <div class="container mt-4 mb-4" style="overflow: hidden">
                <div class="d-flex justify-content-center align-items-center mb-3 blog-images-1">
                    <a href="" class="" style="height: inherit">
                        <div class="image-box me-3" style="width: 40vw;">
                            <img src="{{ asset('images/client/image-1.png') }}" alt="">
                            <p class="text-white d-md-block d-none">Lorem, ipsum dolor.</p>
                        </div>
                    </a>
                    <div class="image-box">
                        <img src="{{ asset('images/client/image-2.png') }}" alt="">
                        <p class="text-white d-md-block d-none">Lorem, ipsum dolor.</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center blog-images-2">
                    <div class="image-box me-3">
                        <img src="{{ asset('images/client/image-3.png') }}" alt="">
                        <p class="text-white d-md-block d-none">Lorem, ipsum dolor.</p>
                    </div>
                    <div class="image-box">
                        <img src="{{ asset('images/client/image-4.png') }}" alt="">
                        <h1 class="text-white">Vezi toate articolele pe blog</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="shop-section">
            <div class="container " style="margin-top:500px !important">
                <div class="shop-content" style="margin-top: 500px">
                    <h1>DESCOPEARA PRODUSE</h1>
                </div>
            </div>
        </div> --}}

        {{-- <div class="products-section">
            <div class="products-container">
                <h2>DESCOPERĂ PRODUSE</h2>

                <div class="products-grid">
                    <div class="product">
                        <img src="{{ asset('images/client/product-1.png') }}" alt="Medalioane">
                        <h3>MEDALIOANE</h3>
                    </div>
                    <div class="product">
                        <img src="{{ asset('images/client/product-2.png') }}" alt="Copaci din Cristal">
                        <h3>COPACI DIN CRISTAL</h3>
                    </div>
                    <div class="product">
                        <img src="{{ asset('images/client/product-3.png') }}" alt="Piramide">
                        <h3>PIRAMIDE</h3>
                    </div>
                    <div class="product">
                        <img src="{{ asset('images/client/product-4.png') }}" alt="Picturi">
                        <h3>PICTURI</h3>
                    </div>
                </div>

                <p class="description">
                    Office ipsum you must be muted. Hill join social harvest old protocol...
                </p>
            </div>
        </div> --}}

        <div
            class="container-fluid product-section py-5 d-flex justify-content-center align-items-center flex-direction-column">
            <div class="container product-container text-white p-5 rounded-4 d-flex flex-column">
                <h2 class="text-uppercase fw-bold mb-4 text-center">
                    <a href="" class="text-decoration-none">
                        Descoperă Produse
                    </a>
                </h2>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 text-center flex-grow-1">
                    <a href="" class="text-decoration-none">
                        <div class="col d-flex">
                            <div class="card my-gradient-card border-0 bg-transparent flex-grow-1 d-flex flex-column">
                                <div
                                    class="p-3 rounded product-bg flex-grow-1 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('images/client/product-1.png') }}" class="img-fluid"
                                        alt="Medalioane">
                                </div>
                                <h5 class="mt-3 text-white">MEDALIOANE</h5>
                            </div>
                        </div>
                    </a>

                    <a href="/product-1" class="text-decoration-none">
                        <div class="col d-flex">
                            <div class="card my-gradient-card border-0 bg-transparent flex-grow-1 d-flex flex-column">
                                <div
                                    class="p-3 rounded product-bg flex-grow-1 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('images/client/product-2.png') }}" class="img-fluid"
                                        alt="Copaci din Cristal">
                                </div>
                                <h5 class="mt-3 text-white">COPACI DIN CRISTAL</h5>
                            </div>
                        </div>
                    </a>

                    <a href="/product-1" class="text-decoration-none">
                        <div class="col d-flex">
                            <div class="card my-gradient-card border-0 bg-transparent flex-grow-1 d-flex flex-column">
                                <div
                                    class="p-3 rounded product-bg flex-grow-1 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('images/client/product-3.png') }}" class="img-fluid"
                                        alt="Piramide">
                                </div>
                                <h5 class="mt-3 text-white">PIRAMIDE</h5>
                            </div>
                        </div>
                    </a>

                    <a href="/product-1" class="text-decoration-none">
                        <div class="col d-flex">
                            <div class="card my-gradient-card border-0 bg-transparent flex-grow-1 d-flex flex-column">
                                <div
                                    class="p-3 rounded product-bg flex-grow-1 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('images/client/product-4.png') }}" class="img-fluid"
                                        alt="Picturi">
                                </div>
                                <h5 class="mt-3 text-white">PICTURI</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <p class="text-center mt-4">
                    Office ipsum you must be muted. Hill join social harvest old protocol need emails spaces not.
                </p>
            </div>
        </div>


    </div>
@endsection
