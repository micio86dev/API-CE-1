<?php

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $cities = ['Milano', 'Roma', 'Torino', 'Bologna', 'Firenze', 'Napoli', 'Venezia', 'Genova'];
        $provinces = ['MI', 'RM', 'TO', 'BO', 'FI', 'NA', 'VE', 'GE'];
        
        $index = $this->faker->numberBetween(0, count($cities) - 1);
        
        return [
            'city' => $cities[$index],
            'province' => $provinces[$index],
            'country' => 'Italia',
            'street' => 'Via ' . $this->faker->streetName(),
            'street_number' => $this->faker->buildingNumber(),
            'zip' => $this->faker->postcode(),
            'lat' => $this->faker->latitude(36, 47),
            'lng' => $this->faker->longitude(6, 18),
        ];
    }
}