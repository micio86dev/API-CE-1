<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        $fakerIt = \Faker\Factory::create('it_IT');
        $fakerEn = \Faker\Factory::create('en_US');

        $descIt = $fakerIt->optional(0.7)->sentence();
        $descEn = $descIt ? $fakerEn->sentence() : null;

        return [
            'name' => [
                'it' => $fakerIt->words(2, true),
                'en' => $fakerEn->words(2, true),
            ],
            'description' => $descIt ? ['it' => $descIt, 'en' => $descEn] : null,
            'published_at' => $fakerIt->optional(0.7)->dateTimeBetween('-5 years', 'now'),
        ];
    }
}
