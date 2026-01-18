<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Customer;
use App\Models\Type;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $shopType = Type::where('alias', 'shop')->first();
        $warehouseType = Type::where('alias', 'warehouse')->first();
        $publisherType = Type::where('alias', 'publisher')->first();

        // Crea 3-5 locations per ogni customer
        foreach ($customers as $customer) {
            $numLocations = fake()->numberBetween(2, 5);
            
            for ($i = 0; $i < $numLocations; $i++) {
                $location = Location::factory()->create([
                    'customer_id' => $customer->id,
                    'name' => $customer->name . ' - ' . fake()->city(),
                ]);

                // Crea indirizzo per la location (polymorphic)
                $location->address()->create([
                    'city' => fake()->randomElement(['Milano', 'Roma', 'Torino', 'Bologna', 'Firenze', 'Napoli']),
                    'province' => fake()->randomElement(['MI', 'RM', 'TO', 'BO', 'FI', 'NA']),
                    'country' => 'Italia',
                    'street' => 'Via ' . fake()->streetName(),
                    'street_number' => fake()->buildingNumber(),
                    // CAP (Italy) is 5 digits; column is zip(7)
                    'zip' => fake()->numerify('#####'),
                    'lat' => fake()->latitude(36, 47),
                    'lng' => fake()->longitude(6, 18),
                ]);

                // Assegna tipo alla location (polymorphic many-to-many)
                if ($customer->mine === 'y') {
                    // Se è "mine", è un warehouse
                    $location->types()->attach($warehouseType->id);
                } else {
                    // Altrimenti può essere shop o publisher
                    $type = fake()->randomElement([$shopType, $publisherType]);
                    $location->types()->attach($type->id);
                }
            }
        }
    }
}
