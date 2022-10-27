<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_date' => $this->faker->dateTimeBetween(),
            'expires_at' => $this->faker->dateTimeBetween('now', '+8 week' ),
            'status' => 'pending',
            'client_id' => rand(1,10),
            'clp_usd' => 850.25,
            'exchange_rate' => 500
        ];
    }
}
