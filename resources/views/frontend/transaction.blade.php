@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">My Transactions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($transactions->isEmpty())
        <div class="alert alert-warning">You have no transactions yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Shipment</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Products</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>#{{ $transaction->id }}</td>
                            <td>
                                <strong>{{ $transaction->shipment->name }}</strong><br>
                                <span class="text-muted">{{ number_format($transaction->shipment->price, 0, ',', '.') }} IDR</span><br>
                                <small>Estimated: {{ $transaction->shipment->estimated }}</small>
                            </td>
                            <td>
                                <span class="badge
                                    {{ $transaction->status == 'pending' ? 'bg-warning' : ($transaction->status == 'completed' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>{{ number_format($transaction->total, 0, ',', '.') }} IDR</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach($transaction->items as $item)
                                        <li>
                                            <strong>{{ $item->product->name }}</strong> ({{ $item->quantity }}x) -
                                            <span class="text-muted">{{ number_format($item->price, 0, ',', '.') }} IDR</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
