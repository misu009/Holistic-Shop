@extends('admin.layout')

@section('title', 'Comanda #' . $order->id)

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Detalii comandă #{{ $order->id }}</h2>

        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Informații client</div>
            <div class="card-body">
                {{-- Client type --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tip client:</strong>
                        {{ $order->client_type === 'natural' ? 'Persoană Fizică' : 'Persoană Juridică' }}
                    </div>
                </div>

                {{-- Personal info --}}
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Nume:</strong> {{ $order->full_name }}</div>
                    <div class="col-md-6"><strong>Email:</strong> {{ $order->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Telefon:</strong> {{ $order->phone }}</div>
                    @if ($order->client_type === 'natural')
                        <div class="col-md-6"><strong>Data nașterii:</strong>
                            {{ \Carbon\Carbon::parse($order->birth_date)->format('d M Y') }}</div>
                    @endif
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Țară:</strong> {{ $order->country }}</div>
                    <div class="col-md-6"><strong>Oraș:</strong> {{ $order->city }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Adresă:</strong> {{ $order->address }}</div>
                    <div class="col-md-6"><strong>Cod poștal:</strong> {{ $order->postal_code }}</div>
                </div>

                {{-- Legal client info --}}
                @if ($order->client_type === 'legal')
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Denumire firmă:</strong> {{ $order->company_name }}</div>
                        <div class="col-md-6"><strong>CUI / CIF:</strong> {{ $order->company_cui }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Reg. Com.:</strong> {{ $order->company_reg ?? '—' }}</div>
                        <div class="col-md-6"><strong>Adresă firmă:</strong> {{ $order->company_address }}</div>
                    </div>
                @endif

                <div class="row mb-2">
                    <div class="col-md-6"><strong>Note:</strong> {{ $order->notes ?? '—' }}</div>
                    @if ($order->wants_soul_customization)
                        <div class="col-md-6"><i class="bi bi-stars"></i> <strong>Atenție!</strong> Clientul a solicitat
                            personalizarea produsului conform energiei și datei de naștere.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Produse comandate</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Produs</th>
                            <th>Cantitate</th>
                            <th>Preț unitar</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }} RON</td>
                                <td>{{ number_format($item->quantity * $item->price, 2) }} RON</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end fw-bold fs-5 mt-3">
                    Total comandă: {{ number_format($order->total, 2) }} RON
                </div>
            </div>
        </div>

        {{-- Status update --}}
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Status comandă</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">Status curent:</span>
                        <span class="badge bg-{{ $order->status->getBadgeColor() }}">
                            {{ $order->status->getLabel() }}
                        </span>
                    </div>
                    <div class="mt-3">
                        <select name="status" class="form-select w-auto d-inline">
                            @foreach (\App\Models\Enums\Order\OrderStatusEnum::values() as $status => $value)
                                <option value="{{ $value }}" @selected($order->status->value === $value)>
                                    {{ \App\Models\Enums\Order\OrderStatusEnum::from($value)->getLabel() }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success ms-2">Actualizează status</button>
                    </div>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            ← Înapoi la lista comenzilor
        </a>
    </div>
@endsection
