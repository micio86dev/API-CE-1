<?php

namespace Database\Factories;

use App\Models\BookQuantity;
use App\Models\Book;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookQuantityFactory extends Factory
{
    protected $model = BookQuantity::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'location_id' => Location::factory(),
            'quantity' => $this->faker->numberBetween(0, 200),
        ];
    }
}