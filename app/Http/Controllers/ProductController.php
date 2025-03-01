<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display the product list with search functionality
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('category', 'like', "%{$searchTerm}%")
                ->orWhere('price', 'like', "%{$searchTerm}%");
        }

        $products = $query->paginate(10); // Adjust per page count as needed


        // Check if the request expects a JSON response
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $products
            ], 200, ['Content-Type' => 'application/json']);
        }

        return view('products.index', compact('products'));


    }

    // Show the form to create a new product
    public function create()
    {
        return view('products.create');
    }

    // Store the new product in the database (with image)
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            'short_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'seo_tags' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePaths[] = $image->store('products/images', 'public');
            }
        }

        // Create the product record
        Product::create([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            'price' => $validatedData['price'],
            'image' => json_encode($imagePaths), // Store images as JSON
            'short_description' => $validatedData['short_description'],
            'long_description' => $validatedData['long_description'],
            'stock' => $validatedData['stock'],
            'status' => $validatedData['status'],
            'seo_tags' => $validatedData['seo_tags'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    // Show the form to edit an existing product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update an existing product in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update the product data
        $product->name = $validatedData['name'];
        $product->category = $validatedData['category'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];

        // Handle image update (if any)
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Store the new image
            $product->image = $request->file('image')->store('products', 'public');
        }

        // Save the product updates
        $product->save();

        return response()->json(['success' => true]);
    }


    // Delete a product from the database
    public function destroy(Product $product)
    {
        if ($product->image) {
            // Assuming images are stored as JSON array, decode and delete all images
            $images = json_decode($product->image);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
