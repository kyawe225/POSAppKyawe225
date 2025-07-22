<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing records if needed (optional)
        // PaymentMethod::truncate();
        
        // Define payment methods data
        $paymentMethods = [
            [
                'method_name' => 'Visa Credit Card',
                'method_type' => 'credit_card',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Mastercard Credit Card',
                'method_type' => 'credit_card',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'American Express',
                'method_type' => 'credit_card',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Visa Debit Card',
                'method_type' => 'debit_card',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Mastercard Debit Card',
                'method_type' => 'debit_card',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'PayPal',
                'method_type' => 'paypal',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'PayPal Express',
                'method_type' => 'paypal',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Bank Transfer',
                'method_type' => 'bank_transfer',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Wire Transfer',
                'method_type' => 'bank_transfer',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Cash on Delivery',
                'method_type' => 'cash',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Cash Payment',
                'method_type' => 'cash',
                // 'is_active' => false, // Example of inactive method
            ],
            [
                'method_name' => 'Apple Pay',
                'method_type' => 'other',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Google Pay',
                'method_type' => 'other',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Stripe',
                'method_type' => 'other',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Square',
                'method_type' => 'other',
                // 'is_active' => true,
            ],
            [
                'method_name' => 'Cryptocurrency',
                'method_type' => 'other',
                
            ],
        ];

        // Insert using Eloquent
        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                ['method_name' => $method['method_name']], // Check for existing
                $method // Data to insert/update
            );
        }
    }
}
