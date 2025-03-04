@extends('layouts.frontend')

@section('content')
<div class="container py-5 text-center">
    <i class="ecicon eci-check-circle text-success display-1"></i>
    <h2 class="mt-4">Thank You for Your Purchase!</h2>
    <p class="lead">Your order has been successfully placed.</p>

    <div class="card mx-auto mt-4 shadow-sm" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
            <p><strong>Transaction ID:</strong> #{{ $transaction->id }}</p>
            <p><strong>Shipment:</strong> {{ $transaction->shipment->name }} ({{ number_format($transaction->shipment->price, 0, ',', '.') }} IDR)</p>
            <p><strong>Status:</strong>
                <span class="badge
                    {{ $transaction->status == 'pending' ? 'bg-warning' : ($transaction->status == 'completed' ? 'bg-success' : 'bg-danger') }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </p>
            <p><strong>Total Payment:</strong> {{ number_format($transaction->total, 0, ',', '.') }} IDR</p>

            <h5 class="mt-3">Products Ordered</h5>
            <ul class="list-group">
                @foreach($transaction->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item->product->name }}</strong> <br>
                            <small class="text-muted">{{ $item->quantity }}x - {{ number_format($item->price, 0, ',', '.') }} IDR</small>
                        </div>
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="50">
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="{{ route('transactions') }}" class="btn btn-success mt-4">View My Transactions</a>
    <a href="{{ route('home') }}" class="btn btn-outline-primary mt-4">Back to Home</a>
</div>
@endsection
