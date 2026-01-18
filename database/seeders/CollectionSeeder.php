<?php

namespace Database\Seeders;

use App\Models\Collection;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            [
                'name' => ['it' => 'Classici della Letteratura', 'en' => 'Literary Classics'],
                'description' => [
                    'it' => 'I grandi classici che hanno segnato la storia della letteratura mondiale',
                    'en' => 'Great classics that shaped the history of world literature',
                ],
                'published_at' => now()->subYears(10),
            ],
            [
                'name' => ['it' => 'Fantasy Epico', 'en' => 'Epic Fantasy'],
                'description' => ['it' => 'Avventure epiche in mondi fantastici', 'en' => 'Epic adventures in fantasy worlds'],
                'published_at' => now()->subYears(5),
            ],
            [
                'name' => ['it' => 'Gialli e Noir', 'en' => 'Mystery & Noir'],
                'description' => ['it' => 'Misteri da risolvere e storie noir avvincenti', 'en' => 'Mysteries to solve and gripping noir stories'],
                'published_at' => now()->subYears(3),
            ],
            [
                'name' => ['it' => 'Contemporanei', 'en' => 'Contemporary'],
                'description' => ['it' => 'La narrativa del nostro tempo', 'en' => 'Fiction of our time'],
                'published_at' => now()->subYear(),
            ],
            [
                'name' => ['it' => 'Horror e Thriller', 'en' => 'Horror & Thriller'],
                'description' => ['it' => 'Storie che ti terranno con il fiato sospeso', 'en' => 'Stories that will keep you on edge'],
                'published_at' => now()->subMonths(6),
            ],
        ];

        foreach ($collections as $collection) {
            Collection::create($collection);
        }

        // Extra random collections, but still seeded as translations
        $fakerIt = FakerFactory::create('it_IT');
        $fakerEn = FakerFactory::create('en_US');

        for ($i = 0; $i < 10; $i++) {
            $descIt = $fakerIt->optional(0.7)->sentence();
            $descEn = $descIt ? $fakerEn->sentence() : null;

            Collection::create([
                'name' => [
                    'it' => $fakerIt->words(2, true),
                    'en' => $fakerEn->words(2, true),
                ],
                'description' => $descIt ? ['it' => $descIt, 'en' => $descEn] : null,
                'published_at' => $fakerIt->optional(0.7)->dateTimeBetween('-5 years', 'now'),
            ]);
        }
    }
}