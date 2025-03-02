@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-dark">Checkout - Pilih Metode Pengiriman</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/checkout/shipment') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Metode Pengiriman</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($shippingMethods as $method)
                    <li class="list-group-item d-flex align-items-center border border-secondary rounded mb-2">
                        <input type="radio" name="shipping_method" value="{{ $method['id'] }}" class="form-check-input me-3" required>
                        <i class="ecicon {{ $method['icon'] ?? '' }} text-primary fs-4 me-3"></i>
                        <div class="flex-grow-1">
                            <strong>{{ $method['name'] }}</strong>
                            <div class="text-muted">{{ number_format($method['price'], 0, ',', '.') }} IDR</div>
                            <small class="text-secondary">({{ $method['estimated'] }})</small>
                        </div>
                    </li>
                    @endforeach
                </ul>

                @error('shipping_method')
                    <p class="text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-4">
            Lanjutkan Pembayaran
        </button>
    </form>
</div>
@endsection
