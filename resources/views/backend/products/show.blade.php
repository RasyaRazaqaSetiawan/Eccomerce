@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Product Details</h1>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{ $product->name }}</h3>
                <p class="card-text"><strong>Description:</strong> {{ $product->description ?? 'No description available' }}</p>
                <p class="card-text"><strong>Price:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                <p class="card-text">
                    <strong>Category:</strong> {{ $product->category->name ?? 'No Category' }}
                </p>
                <p class="card-text">
                    <strong>Slug:</strong> {{ $product->slug }}
                </p>
                <p class="card-text">
                    <strong>Created At:</strong> {{ $product->created_at->format('d M Y, H:i') }}
                </p>
                <p class="card-text">
                    <strong>Updated At:</strong> {{ $product->updated_at->format('d M Y, H:i') }}
                </p>

                @if ($product->image)
                    <div class="mb-3">
                        <strong>Image:</strong><br>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 300px;">
                    </div>
                @else
                    <p><strong>Image:</strong> No image available</p>
                @endif

                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit Product</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
