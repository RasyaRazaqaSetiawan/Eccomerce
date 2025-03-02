<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $shippingMethods = [
            ['id' => 1, 'name' => 'Standard Shipping', 'price' => 10000, 'estimated' => '3-5 Days', 'icon' => 'eci-truck'],
            ['id' => 2, 'name' => 'Express Shipping', 'price' => 20000, 'estimated' => '1-2 Days', 'icon' => 'eci-paper-plane-o'],
            ['id' => 3, 'name' => 'Same Day Delivery', 'price' => 50000, 'estimated' => 'Same Day', 'icon' => 'eci-bicycle'],
        ];

        return view('frontend.checkout', compact('shippingMethods'));
    }

    public function selectShipment(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required',
        ]);

        return redirect('/checkout')->with('success', 'Shipping method selected successfully!');
    }
}
