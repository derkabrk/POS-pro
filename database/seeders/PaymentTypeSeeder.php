<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = Business::pluck('id');

        $defaultPaymentTypes = ['Cash', 'Card', 'Check', 'Mobile Pay', 'Due'];

        $payment_types = [];

        foreach ($businesses as $business_id) {
            foreach ($defaultPaymentTypes as $type) {
                $payment_types[] = [
                    'business_id' => $business_id,
                    'name' => $type,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        PaymentType::insert($payment_types);
    }
}
