<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'payment_method' => $this->faker->randomElement(['Credit Card', 'PayPal', 'Bank Transfer']),
            'transaction_id' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['Pending', 'Completed', 'Failed']),
        ];
    }
}
