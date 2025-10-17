<!DOCTYPE html>
<html>

<body>
    <h2>Nouă comandă primită!</h2>
    <p><strong>Client:</strong> {{ $order->full_name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Total:</strong> {{ number_format($order->total, 2) }} RON</p>
    <p><strong>Comanda ID:</strong> #{{ $order->id }}</p>
</body>

</html>
