<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nume complet</th>
                <th scope="col">Tip client</th>
                <th scope="col">Email</th>
                <th scope="col">Nr tel</th>
                <th scope="col">Status</th>
                <th scope="col">Data inregistrarii</th>
                <th scope="col">Actiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                <tr>
                    <td>{{ $order->full_name }}</td>
                    <td>{{ $order->client_type === 'natural' ? 'Persoană Fizică' : 'Persoană Juridică' }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status->getBadgeColor() }}">
                            {{ $order->status->getLabel() }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-eye"></i> Vizualizează
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>

</div>
