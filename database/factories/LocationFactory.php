<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' ' . $this->faker->city(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'customer_id' => Customer::factory(),
        ];
    }
}