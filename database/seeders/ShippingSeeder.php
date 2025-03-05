<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shipments')->insert([
            [
                'shipping_method' => 'Free Shipping',
                'price' => 0,
                'tracking_number' => 'FREE123456789',
                'status' => 'Shipped',
                'estimated' => '7 or 10 days arrived',
                'icon' => asset('frontend/assets/images/icons/free-delivery.png'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipping_method' => 'Standard Shipping',
                'price' => 5000,
                'tracking_number' => 'STD987654321',
                'status' => 'Pending',
                'estimated' => '4 or 7 days arrived',
                'icon' => asset('frontend/assets/images/icons/delivery.png'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipping_method' => 'Express Shipping',
                'price' => 15000,
                'tracking_number' => 'EXP56789',
                'status' => 'Delivered',
                'estimated' => '2 or 3 days arrived',
                'icon' => asset('frontend/assets/images/icons/fast-delivery.png'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
