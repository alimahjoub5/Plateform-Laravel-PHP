<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'ProjectID' => Project::factory(),
            'ClientID' => User::factory(),
            'Amount' => $this->faker->randomFloat(2, 100, 10000),
            'Status' => $this->faker->randomElement(['Pending', 'Paid', 'Overdue']),
            'DueDate' => $this->faker->dateTimeBetween('now', '+1 month'),
            'Description' => $this->faker->sentence(),
        ];
    }
}
