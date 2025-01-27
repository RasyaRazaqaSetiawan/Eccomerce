<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('backend.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar jika ada
        $imagePath = 'backend/assets/media/svg/files/blank-image.svg'; // Path default
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/products', 'public');
        }

        $validated['slug'] = Str::slug($request->name); // Generate slug

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('backend.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $categories = Category::all(); // Muat semua kategori untuk dropdown
        $product = Product::findOrFail($id); // Cari produk berdasarkan ID
        return view('backend.products.edit', compact('product', 'categories')); // Arahkan ke halaman edit
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id); // Cari produk berdasarkan ID

        // Validasi input pengguna
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        // Perbarui slug jika nama produk berubah
        $validated['slug'] = Str::slug($request->name);

        // Cek apakah ada file gambar baru diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && $product->image !== 'backend/assets/media/svg/files/blank-image.svg') {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Jika tidak ada file gambar baru, gunakan gambar lama
        $validated['image'] = $validated['image'] ?? $product->image;

        // Update produk di database
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image); // Hapus gambar
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
