<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-black fw-bold" id="orderModalLabel">Finalizează comanda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Închide"></button>
            </div>

            <form action="{{ route('client.orders.store') }}" method="POST" class="text-black" id="orderForm">
                @csrf
                <div class="modal-body p-4">
                    {{-- Display all validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nume complet</label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telefon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Data nașterii</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Țară</label>
                            <select name="country" class="form-select" required>
                                <option value="">Selectează țara</option>
                                @foreach ($countries as $code => $name)
                                    <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Oraș</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Adresă livrare</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cod poștal</label>
                            <input type="text" name="postal_code" class="form-control"
                                value="{{ old('postal_code') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Note suplimentare</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Ex: instrucțiuni de livrare...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Tip client</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="client_type" id="natural"
                                        value="natural"
                                        {{ old('client_type', 'natural') === 'natural' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="natural">Persoană Fizică</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="client_type" id="legal"
                                        value="legal" {{ old('client_type') === 'legal' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="legal">Persoană Juridică</label>
                                </div>
                            </div>
                        </div>

                        <div id="legal-fields" style="display: none;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Denumire firmă</label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ old('company_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">CUI / CIF</label>
                                    <input type="text" name="company_cui" class="form-control"
                                        value="{{ old('company_cui') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Reg. Com.</label>
                                    <input type="text" name="company_reg" class="form-control"
                                        value="{{ old('company_reg') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Adresa firmă</label>
                                    <input type="text" name="company_address" class="form-control"
                                        value="{{ old('company_address') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreeCheckbox"
                                    name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="agreeCheckbox">
                                    Transportul pentru România este gratuit, iar pentru restul Europei și Americii sunt
                                    de acord să fiu contactat cu datele de contact oferite.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreeCheckbox2"
                                    name="agree_terms2" {{ old('agree_terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="agreeCheckbox2">
                                    Am luat la cunostinta si continutul celor 2 bife de la pasul precedent si sunt de
                                    acord
                                </label>
                            </div>
                            @error('agree_terms')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
                    <button type="submit" class="btn btn-custom" id="submitButton" disabled>Trimite comanda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkbox1 = document.getElementById('agreeCheckbox');
        const checkbox2 = document.getElementById('agreeCheckbox2');
        const submitButton = document.getElementById('submitButton');

        function toggleSubmitButton() {
            if (checkbox1.checked && checkbox2.checked) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        toggleSubmitButton();

        checkbox1.addEventListener('change', toggleSubmitButton);
        checkbox2.addEventListener('change', toggleSubmitButton);

        const clientTypeRadios = document.querySelectorAll('input[name="client_type"]');
        const legalFields = document.getElementById('legal-fields');

        function toggleLegalFields() {
            const selected = document.querySelector('input[name="client_type"]:checked').value;
            legalFields.style.display = selected === 'legal' ? 'block' : 'none';
        }

        clientTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleLegalFields);
        });

        toggleLegalFields();
    });
</script>
