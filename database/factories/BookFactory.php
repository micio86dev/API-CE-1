<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $fakerIt = \Faker\Factory::create('it_IT');
        $fakerEn = \Faker\Factory::create('en_US');

        $plotIt = $fakerIt->optional(0.9)->paragraph(3);
        $plotEn = $plotIt ? $fakerEn->paragraph(3) : null;

        return [
            'title' => [
                'it' => $fakerIt->sentence($fakerIt->numberBetween(2, 5)),
                'en' => $fakerEn->sentence($fakerEn->numberBetween(2, 5)),
            ],
            'price' => $fakerIt->randomFloat(2, 5, 50),
            'plot' => $plotIt ? ['it' => $plotIt, 'en' => $plotEn] : null,
            'published_at' => $fakerIt->dateTimeBetween('-50 years', '-1 year'),
            'collection_id' => Collection::factory(),
        ];
    }
}