@extends('client.layout')

@section('title', 'Cart')

@section('content')
    <div class="cart mt-5">
        <div class="container p-5">
            <h2 class="text-black">Cosul tau de cumparaturi</h2>
            @if (Session::get('ordered'))
                <p class="fs-2 mt-5">{{ Session::get('ordered') }}</p>
                <a href="{{ route('client.shop.index') }}" class="btn btn-custom btn-lg mt-3">Continua cumparaturile</a>
            @elseif (count($cartItems) === 0)
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
                <div class="form-check mb-3">
                    <input class="form-check-input check-condition" type="checkbox" id="check1"
                        @if ($errors->any()) checked @endif>
                    <label class="form-check-label text-black" for="check1">
                        <span class="text-danger">*</span> Sunt de acord cu prelucrarea datelor mele personale conform GDPR
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input check-condition" type="checkbox" id="check2"
                        @if ($errors->any()) checked @endif>
                    <label class="form-check-label text-black" for="check2">
                        <span class="text-danger">*</span> Inteleg ca produsele pe care le voi primi sunt personalizate si
                        nu vor fi identice cu
                        cele din poze
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.check-condition');
            const button = document.getElementById('confirmButton');

            if (checkboxes.length < 2) {
                button.disabled = true;
                return;
            }

            const toggleButton = () => {
                const allChecked = Array.from(checkboxes).every(ch => ch.checked);
                button.disabled = !allChecked;
            };

            toggleButton();

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleButton);
            });
        });
    </script>

@endsection
