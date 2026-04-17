@extends('client.layout')

@section('title', 'Cart')

@section('content')
    <div class="cart mt-5">
        <div class="container p-5">
            <h2 class="text-black">Cosul tau de cumparaturi</h2>
            @if (Session::get('ordered'))
                <p class="fs-2 mt-5">{{ Session::get('ordered') }}</p>
                <a href="{{ route('client.shop.index') }}" class="btn btn-custom btn-lg mt-3">Continua cumparaturile</a>
            @elseif (empty($cartItems))
                <p class="fs-2 mt-5">Cosul tau este gol...</p>
                <a href="{{ route('client.shop.index') }}" class="btn btn-custom btn-lg mt-3">Continua cumparaturile</a>
            @else
                <div class="mb-5">
                    @foreach ($cartItems as $item)
                        <x-client.cart-card :product="$item" />
                    @endforeach
                </div>
                <div
                    class="d-flex border-golden w-100 bg-white flex-row justify-content-between align-items-center mt-5 mb-5 p-3">
                    <div>
                        <p class="fs-4 text-danger text-uppercase">subtotal</p>
                    </div>
                    <div>
                        <p class="fs-4 text-danger text-uppercase">{{ $total }} lei</p>
                    </div>
                </div>

                {{-- FIXED: Added 'check-condition' class and the red '*' star --}}
                <div class="form-check mb-4 mt-3">
                    <input class="form-check-input check-condition" type="checkbox" id="check_tos" required>
                    <label class="form-check-label text-black" for="check_tos">
                        <span class="text-danger">*</span> Sunt de acord cu
                        <a href="#" data-bs-toggle="modal" data-bs-target="#tosModal"
                            class="fw-bold text-decoration-underline" style="color: #b96e2e;">
                            Termenii și Condițiile
                        </a>
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input check-condition" type="checkbox" id="check2"
                        @if ($errors->any()) checked @endif>
                    <label class="form-check-label text-black" for="check2">
                        <span class="text-danger">*</span> Inteleg ca produsele pe care le voi primi sunt personalizate si
                        nu vor fi identice cu cele din poze
                    </label>
                </div>

                <div class="w-100 d-flex justify-content-end">
                    <button id="confirmButton" class="btn btn-custom" disabled data-bs-toggle="modal"
                        data-bs-target="#orderModal">
                        Continua comanda
                    </button>
                </div>
            @endif
        </div>

        <x-client.order-modal :countries="$countries" />

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
                    orderModal.show();
                });
            </script>
        @endif
    </div>

    {{-- TOS Modal Content --}}
    <div class="modal fade" id="tosModal" tabindex="-1" aria-labelledby="tosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="tosModalLabel" style="color: #5b2b12;">
                        {{ $tosPage->title ?? 'Termeni și Condiții' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-black" style="font-size: 1.1rem; line-height: 1.6;">
                    @if (isset($tosPage))
                        {!! $tosPage->content !!}
                    @else
                        <p>Termenii și condițiile nu au fost setate încă.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-bs-dismiss="modal">Am înțeles</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.check-condition');
            const button = document.getElementById('confirmButton');

            // This failsafe was previously triggered because checkboxes.length was 1
            if (checkboxes.length < 2) {
                console.warn("Script logic error: Expected 2 checkboxes, found " + checkboxes.length);
                button.disabled = true;
                return;
            }

            const toggleButton = () => {
                const allChecked = Array.from(checkboxes).every(ch => ch.checked);
                button.disabled = !allChecked;
            };

            // Run once on load to handle pre-checked states
            toggleButton();

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleButton);
            });
        });
    </script>
@endsection