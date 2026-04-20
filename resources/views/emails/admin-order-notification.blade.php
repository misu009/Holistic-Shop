<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Comandă nouă #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: #f9f9f9;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        h2 {
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: center;
        }

        table th {
            background: #f2f2f2;
        }

        .section-title {
            margin-top: 30px;
            font-size: 18px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Nouă comandă primită! (#{{ $order->id }})</h2>

        <p><strong>Data comenzii:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>

        <div class="section-title">Informații client</div>
        <p><strong>Tip client:</strong>
            {{ $order->client_type === 'natural' ? 'Persoană Fizică' : 'Persoană Juridică' }}</p>
        <p><strong>Nume complet:</strong> {{ $order->full_name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Telefon:</strong> {{ $order->phone }}</p>

        @if ($order->client_type === 'natural' && $order->birth_date)
            <p><strong>Data nașterii:</strong> {{ \Carbon\Carbon::parse($order->birth_date)->format('d M Y') }}</p>
        @endif

        <p><strong>Țară:</strong> {{ $order->country }}</p>
        <p><strong>Oraș:</strong> {{ $order->city }}</p>
        <p><strong>Adresă:</strong> {{ $order->address }}</p>
        <p><strong>Cod poștal:</strong> {{ $order->postal_code }}</p>

        @if ($order->client_type === 'legal')
            <div class="section-title">Informații companie</div>
            <p><strong>Denumire firmă:</strong> {{ $order->company_name }}</p>
            <p><strong>CUI / CIF:</strong> {{ $order->company_cui }}</p>
            <p><strong>Reg. Com.:</strong> {{ $order->company_reg ?? '—' }}</p>
            <p><strong>Adresă firmă:</strong> {{ $order->company_address }}</p>
        @endif

        @if (!empty($order->notes))
            <div class="section-title">Note client</div>
            <p>{{ $order->notes }}</p>
        @endif

        @if ($order->wants_soul_customization)
            <div class="section-title" style="color: #b96e2e; font-weight: bold;">✨ Personalizare Energetică Solicitată
            </div>
            <p style="background: #fcf8f5; padding: 10px; border-left: 4px solid #b96e2e; margin-top: 5px;">
                Clientul a bifat opțiunea: <em>"Îmi doresc ca produsul să fie personalizat, făcut special pentru energia
                    mea, conform datei mele de naștere și a nevoilor sufletului meu."</em>
            </p>
            @if ($order->client_type === 'natural' && $order->birth_date)
                <p><strong>Nu uitați să verificați Data Nașterii:</strong>
                    {{ \Carbon\Carbon::parse($order->birth_date)->format('d.m.Y') }}</p>
            @endif
        @endif

        <div class="section-title">Produse comandate</div>
        <table>
            <thead>
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

        <p class="text-right total">
            Total comandă: {{ number_format($order->total, 2) }} RON
        </p>
    </div>
</body>

</html>
