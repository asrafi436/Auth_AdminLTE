@extends('layouts.app')

@section('title', 'Create Product')
@section('breadcrumb-title', 'Create Product')

@push('styles')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- jQuery Steps CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.css">

<!-- Custom CSS for Beautiful Tabs & Buttons -->
<link rel="stylesheet" href="{{ asset('assets/css/stepjs.css') }}">
@endpush

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Create Product</h2>

    <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="stepForm">
            <!-- Step 1: Product Details -->
            <h3>Product Details</h3>
            <section>
                <div class="mb-3">
                    <label for="name">Product Name:</label>
                    <input type="text" name="name" id="name" class="form-control required">
                </div>
                <div class="mb-3">
                    <label for="category">Category:</label>
                    <input type="text" name="category" id="category" class="form-control required">
                </div>
                <div class="mb-3">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" class="form-control required">
                </div>
            </section>

            <!-- Step 2: Product Description -->
            <h3>Product Description</h3>
            <section>
                <div class="mb-3">
                    <label for="short_description">Short Description:</label>
                    <textarea name="short_description" id="short_description" class="form-control required" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="long_description">Long Description:</label>
                    <textarea name="long_description" id="long_description" class="form-control required" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image">Product Images:</label>
                    <input type="file" name="image[]" id="image" class="form-control" multiple>
                </div>
            </section>

            <!-- Step 3: Additional Details -->
            <h3>Additional Details</h3>
            <section>
                <div class="mb-3">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" id="stock" class="form-control required">
                </div>
                <div class="mb-3">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control required">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="seo_tags">SEO Tags:</label>
                    <input type="text" name="seo_tags" id="seo_tags" class="form-control required" placeholder="e.g. Product, Category">
                </div>
            </section>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize jQuery Steps
    $("#stepForm").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,
        labels: {
            finish: "Submit",
            next: "Next",
            previous: "Previous"
        },
        onFinished: function (event, currentIndex) {
            $("#productForm").submit(); // Submit form on finish
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            return $("#productForm").valid(); // Validate before next step
        }
    });

    // Enable jQuery Validation
    $("#productForm").validate({
        errorClass: "text-danger",
        rules: {
            name: "required",
            category: "required",
            price: "required",
            short_description: "required",
            long_description: "required",
            stock: "required",
            status: "required",
            seo_tags: "required"
        },
        messages: {
            name: "Please enter the product name",
            category: "Please enter the category",
            price: "Please enter the price",
            short_description: "Short description is required",
            long_description: "Long description is required",
            stock: "Please enter the stock quantity",
            status: "Please select the status",
            seo_tags: "Please enter SEO tags"
        }
    });
});
</script>
@endpush
