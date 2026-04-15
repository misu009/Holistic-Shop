<div class="d-flex border-golden w-100 bg-white flex-column flex-md-row mt-5 mb-5">
    <div class="text-center p-3 d-flex align-items-center justify-content-center">
        {{-- Safely grab the first image from the media relationship --}}
        <img src="{{ $product['product']->media->first() ? asset('storage/' . $product['product']->media->first()->path) : asset('images/placeholder.png') }}" class="product-image rounded" alt="product image">
    </div>

    <div class="flex-grow-1">
        <div>
            <div class="d-flex flex-column flex-md-row">
                <div class="d-flex flex-column pt-3 pb-3 ps-2 pe-2 flex-grow-1">
                    <p class="text-danger fs-5">PRODUS</p>
                    {{-- Access the name from the Eloquent Model --}}
                    <p class="flex-grow-1 text-black fs-4">{{ $product['product']->name }}</p>
                </div>

                <div class="d-flex flex-column pt-3 pb-3 ps-2 pe-2 flex-grow-0 align-items-start align-items-md-end">
                    <p class="text-danger fs-5">PRET</p>
                    {{-- We can just use the subtotal we already calculated in the controller! --}}
                    <p class="text-black fs-4">{{ number_format($product['subtotal'], 2) }} LEI</p>
                </div>
            </div>

            <div class="d-flex mt-2 pb-2 align-items-center justify-content-between flex-wrap">
                <div class="flex-grow-1 ps-2">
                    <p class="mb-0">
                        {{-- Access the short_description (or excerpt) from the Eloquent Model --}}
                        {{ Str::words(strip_tags(html_entity_decode($product['product']->short_description ?? $product['product']->excerpt)), 12, ' ..') }}
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2 ps-2 pe-2">

                    @if ($product['quantity'] > 1)
                        <form action="{{ route('client.cart.update', $product['product']->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $product['quantity'] - 1 }}">
                            <button type="submit" class="btn qty-btn" aria-label="Decrease quantity">−</button>
                        </form>
                    @else
                        {{-- When qty === 1, clicking - will remove the item --}}
                        <form action="{{ route('client.cart.remove', $product['product']->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn qty-btn" aria-label="Remove item">−</button>
                        </form>
                    @endif

                    <div class="px-2">
                        <span class="fs-5 fw-bold">{{ $product['quantity'] }}</span>
                    </div>

                    <form action="{{ route('client.cart.update', $product['product']->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $product['quantity'] + 1 }}">
                        <button type="submit" class="btn qty-btn" aria-label="Increase quantity">+</button>
                    </form>

                    <form action="{{ route('client.cart.remove', $product['product']->id) }}" method="POST"
                        class="d-inline ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger cart-button px-3 py-1" aria-label="Delete product">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        object-position: center;
    }

    .qty-btn {
        background-color: #f8f9fa;
        /* bootstrap light */
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        color: #222;
        padding: 0.25rem 0.6rem;
        font-size: 1.15rem;
        line-height: 1;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .qty-btn:active,
    .qty-btn:focus {
        box-shadow: 0 0 0 0.12rem rgba(0, 0, 0, 0.06) !important;
    }

    /* Optional: tune your cart-button (delete) style if you already have one */
    .cart-button {
        background-color: #dc3545;
        border: none;
        color: #fff;
        border-radius: 6px;
    }
</style>