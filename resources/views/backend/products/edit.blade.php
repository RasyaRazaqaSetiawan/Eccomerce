@extends('layouts.backend')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Product</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Edit Product</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column flex-lg-row gap-7 gap-lg-10">
                    @csrf
                    @method('PUT') {{-- Tambahkan metode PUT untuk update --}}
                    
                    <!-- Product Details -->
                    <div class="d-flex flex-column flex-lg-grow-1">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label for="name" class="required form-label">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control rich-editor">{{ old('description', $product->description) }}</textarea>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label for="price" class="required form-label">Price</label>
                                    <input type="number" name="price" id="price" class="form-control"
                                        value="{{ old('price', $product->price) }}" required>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label for="stock" class="required form-label">Stock</label>
                                    <input type="number" name="stock" id="stock" class="form-control"
                                        value="{{ old('stock', $product->stock) }}" required>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label for="category_id" class="required form-label">Category</label>
                                    <select name="category_id" id="category_id" data-control="select2" class="form-control">
                                        <option value="" disabled selected>Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('products.index') }}" class="btn btn-light me-5">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="d-flex flex-column w-lg-300px">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Image Product</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <div class="image-input image-input-outline mb-3"
                                    data-kt-image-input="true"
                                    style="background-image: url('{{ $product->image ? asset('storage/' . $product->image) : asset('backend/assets/media/svg/files/blank-image.svg') }}')">
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <input type="file" name="image" id="image" accept=".png, .jpg, .jpeg" />
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
