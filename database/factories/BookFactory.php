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
        return [
            'title' => $this->faker->sentence(rand(2, 5)),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'plot' => $this->faker->optional(0.9)->paragraph(3),
            'published_at' => $this->faker->dateTimeBetween('-50 years', '-1 year'),
            'collection_id' => Collection::factory(),
        ];
    }
}