<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $cities = ['Milano', 'Roma', 'Torino', 'Bologna', 'Firenze', 'Napoli', 'Venezia', 'Genova'];
        $provinces = ['MI', 'RM', 'TO', 'BO', 'FI', 'NA', 'VE', 'GE'];
        
        $index = $this->faker->numberBetween(0, 7);
        
        return [
            'city' => $cities[$index],
            'province' => $provinces[$index],
            'country' => 'Italia',
            'street' => 'Via ' . $this->faker->streetName(),
            'street_number' => $this->faker->buildingNumber(),
            // CAP (Italy) is 5 digits; column is zip(7)
            'zip' => $this->faker->numerify('#####'),
            'lat' => $this->faker->latitude(36, 47),
            'lng' => $this->faker->longitude(6, 18),
        ];
    }
}