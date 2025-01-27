@extends('layouts.backend')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Products</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Products</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" data-kt-ecommerce-product-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Search Product" />
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!-- Tombol Add Product -->
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    Add Product
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table"
                            style="margin-top: 20px;">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">Id</th>
                                    <th class="min-w-100px">Product</th>
                                    <th class="min-w-100px">Qty</th>
                                    <th class="min-w-100px">Price</th>
                                    <th class="min-w-100px">Category</th>
                                    <th class="min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600">
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="symbol symbol-50px">
                                                    <span class="symbol-label"
                                                        style="background-image:url({{ isset($product->image) ? asset('storage/' . $product->image) : asset('backend/assets/media/svg/files/blank-image.svg') }});">
                                                    </span>
                                                </a>
                                                <div class="ms-5">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="text-gray-800 text-hover-primary fs-5 fw-bolder"
                                                        data-kt-ecommerce-product-filter="product_name">{{ $product->name }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pe-0" data-order="2">
                                            @if ($product->stock < 10)
                                                <span class="badge badge-light-warning">Low stock</span>
                                            @endif
                                            <span class="fw-bolder text-warning ms-3">{{ $product->stock }}</span>
                                        </td>
                                        <td class="pe-0">
                                            <span class="fw-bolder text-dark">Rp.
                                                {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="pe-0" data-order="Scheduled">
                                            <div class="badge badge-light-success">{{ $product->category->name }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
