@extends('layouts.backend')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Create Product</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <span class="h-20px border-gray-300 border-start mx-4"></span>

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Add Product</li>
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

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column flex-lg-row gap-7 gap-lg-10">
                    @csrf
                    <!-- Product Name Section -->
                    <div class="d-flex flex-column flex-lg-grow-1">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <!-- Product Name -->
                                <div class="mb-10 fv-row">
                                    <label for="name" class="required form-label">Product Name</label>
                                    <div class="text-muted fs-7 mb-2">Provide a unique product name for better identification.</div>
                                    <input type="text" name="name" id="name" class="form-control mb-2"
                                        placeholder="Enter product name" value="{{ old('name') }}" required>
                                </div>
                                <!-- Description -->
                                <div class="mb-10 fv-row">
                                    <label for="description" class="form-label">Description</label>
                                    <div class="text-muted fs-7 mb-2">Write a detailed description for your product.</div>
                                    <textarea name="description" id="description" class="form-control rich-editor" rows="4">{{ old('description') }}</textarea>
                                </div>
                                <!-- Price -->
                                <div class="mb-10 fv-row">
                                    <label for="price" class="required form-label">Price</label>
                                    <div class="text-muted fs-7 mb-2">Set the price for the product in Rupiah</div>
                                    <input type="number" name="price" id="price" class="form-control"
                                        placeholder="Enter product price" value="{{ old('price') }}" step="0.01" required>
                                </div>
                                <!-- Stock -->
                                <div class="mb-10 fv-row">
                                    <label for="stock" class="required form-label">Stock</label>
                                    <div class="text-muted fs-7 mb-2">Specify the stock availability for the product.</div>
                                    <input type="number" name="stock" id="stock" class="form-control"
                                        placeholder="Enter stock quantity" value="{{ old('stock') }}" required>
                                </div>
                                <!-- Category -->
                                <div class="mb-10 fv-row">
                                    <label for="category_id" class="required form-label">Category</label>
                                    <div class="text-muted fs-7 mb-2">Choose a category that best fits your product.</div>
                                    <select name="category_id" id="category_id" data-control="select2" class="form-control" required>
                                        <option value="" disabled selected>Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Submit Buttons -->
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('products.index') }}" id="kt_ecommerce_add_product_cancel"
                                        class="btn btn-light me-5">Cancel</a>
                                    <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Image Section -->
                    <div class="d-flex flex-column w-lg-300px">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Image Product</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <div class="image-input image-input-empty image-input-outline mb-3"
                                    data-kt-image-input="true"
                                    style="background-image: url('{{asset('backend/assets/media/svg/files/blank-image.svg') }}')">
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <input type="file" name="image" id="image" accept=".png, .jpg, .jpeg" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                                <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted.</div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize Rich Text Editor
        $(document).ready(function() {
            $('.rich-editor').summernote({
                height: 200, // Set editor height
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endsection
