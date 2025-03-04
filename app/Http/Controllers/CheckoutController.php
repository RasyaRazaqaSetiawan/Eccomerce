<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shipment;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $shippingMethods = Shipment::all();

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        $totalAmount = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });


        return view('frontend.checkout', compact('shippingMethods', 'cartItems','totalAmount'));
    }


    public function selectShipment(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required',
        ]);

        return redirect('/checkout')->with('success', 'Shipping method selected successfully!');
    }
    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|exists:shipments,id',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        // Hitung total harga produk
        $totalProductPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Ambil informasi pengiriman
        $shipment = Shipment::findOrFail($request->shipping_method);
        $total = $totalProductPrice + $shipment->price;

        // Simpan transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'shipment_id' => $shipment->id,
            'total' => $total,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Simpan produk ke transaction_items
        foreach ($cartItems as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Kosongkan keranjang setelah transaksi berhasil
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('checkout.success', ['transaction' => $transaction->id])->with('success', 'Checkout berhasil!');
    }
    public function success($transactionId)
    {
        $transaction = Transaction::where('id', $transactionId)
                        ->where('user_id', Auth::id())
                        ->with(['shipment', 'items.product'])
                        ->firstOrFail();

        return view('frontend.checkout_success', compact('transaction'));
    }
}
