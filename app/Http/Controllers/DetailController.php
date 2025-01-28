<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class DetailController extends Controller
{
    public function show($category_slug, $product_slug)
    {
        // Cari kategori berdasarkan slug
        $category = Category::where('slug', $category_slug)->firstOrFail();
    
        // Cari produk berdasarkan slug dan kategori, sekaligus muat relasi category
        $product = Product::with('category')
            ->where('slug', $product_slug)
            ->where('category_id', $category->id)
            ->firstOrFail();
    
        return view('frontend.details', compact('category', 'product'));
    }
}