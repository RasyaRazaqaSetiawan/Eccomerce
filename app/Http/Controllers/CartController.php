<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan daftar produk di keranjang
    public function index()
    {
        // Ambil semua produk di keranjang
        $cart = Cart::where('user_id', Auth::id())->get();
        $cart_count = $cart->sum('quantity');
        
        // Ambil detail produk terkait
        $products = Product::whereIn('id', $cart->pluck('product_id'))->get()->keyBy('id');
        
        return view('frontend.cart', compact('cart', 'cart_count', 'products'));
    }

    public function store(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
    
        // Cek apakah produk sudah ada di keranjang
        $cart = Cart::where('product_id', $product_id)
                    ->where('user_id', Auth::id())
                    ->first();
    
        if ($cart) {
            // Update quantity jika produk sudah ada
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            // Tambahkan produk baru ke keranjang
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }
    
        // **Hitung jumlah produk unik di keranjang**
        $cart_count = Cart::where('user_id', Auth::id())->count();
    
        // Simpan cart count di session untuk navbar
        session(['cart_count' => $cart_count]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully added to cart.',
            'cart_count' => $cart_count, // Mengirim jumlah produk unik, bukan total quantity
        ]);
    }
    

    public function update(Request $request)
    {
        $quantities = $request->input('quantities');  // Ambil data kuantitas dari form
        foreach ($quantities as $cart_id => $quantity) {
            // Temukan cart item berdasarkan cart_id dan perbarui kuantitasnya
            $cart_item = Cart::findOrFail($cart_id);
            $cart_item->quantity = $quantity; // Update quantity
            $cart_item->save();
        }
    
        // Update cart count di session
        $cart_count = Cart::where('user_id', Auth::id())->count();
        session(['cart_count' => $cart_count]);
    
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }
    

    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();
    
        $cart_count = Cart::where('user_id', Auth::id())->count();
        session(['cart_count' => $cart_count]);
    
        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully.');
    }
}
