@extends('layouts.app')

@section('title', 'Product List')
@section('breadcrumb-title', 'Product List')

@section('content')
<div class="container mt-4">
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <!-- Search Form -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-control me-2" />
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <!-- View Button -->
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewProductModal" data-product="{{ $product->toJson() }}">View</button>

                        <!-- Edit Button -->
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product="{{ $product->toJson() }}">Edit</button>

                        <!-- Delete Button -->
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $products->withQueryString()->links() }}
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">View Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="modal-name"></span></p>
                <p><strong>Category:</strong> <span id="modal-category"></span></p>
                <p><strong>Price:</strong> <span id="modal-price"></span></p>
                <p><strong>Stock:</strong> <span id="modal-stock"></span></p>
                <p><strong>Short Description:</strong> <span id="modal-description"></span></p>
                <p><strong>Details:</strong> <span id="modal-details"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" action="{{ route('products.update', '') }}" method="POST" enctype="multipart/form-data >
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-product-id">
                    
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" id="edit-name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" id="edit-category" name="category" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" id="edit-price" name="price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" id="edit-stock" name="stock" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // View Product Modal
    var viewProductModal = document.getElementById('viewProductModal');
    viewProductModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productData = JSON.parse(button.getAttribute('data-product'));

        document.getElementById('modal-name').textContent = productData.name || 'N/A';
        document.getElementById('modal-category').textContent = productData.category || 'N/A';
        document.getElementById('modal-price').textContent = productData.price || 'N/A';
        document.getElementById('modal-stock').textContent = productData.stock || 'N/A';
        // document.getElementById('modal-description').textContent = productData.description || 'N/A';
        // document.getElementById('modal-details').textContent = productData.details || 'N/A';
    });

    // Edit Product Modal
    var editProductModal = document.getElementById('editProductModal');
    var editProductForm = document.getElementById('editProductForm');

    editProductModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productData = JSON.parse(button.getAttribute('data-product'));

        document.getElementById('edit-product-id').value = productData.id;
        document.getElementById('edit-name').value = productData.name;
        document.getElementById('edit-category').value = productData.category;
        document.getElementById('edit-price').value = productData.price;
        document.getElementById('edit-stock').value = productData.stock;
        document.getElementById('edit-product-id').disabled = true;
        

    });

    editProductForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var productId = document.getElementById('edit-product-id').value;
        var formData = new FormData(this);

        fetch(`/products/${productId}`, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Product updated successfully!");
                location.reload();
            } else {
                alert("Failed to update product.");
            }
        })
        .catch(error => console.log(error));
    });
});

</script>

@endpush

@endsection
