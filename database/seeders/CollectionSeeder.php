<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;
use app\Models\BaseModel;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        // Crea alcune collezioni predefinite
        $collections = [
            [
                'name' => 'Classici della Letteratura',
                'description' => 'I grandi classici che hanno segnato la storia della letteratura mondiale',
                'published_at' => now()->subYears(10),
            ],
            [
                'name' => 'Fantasy Epico',
                'description' => 'Avventure epiche in mondi fantastici',
                'published_at' => now()->subYears(5),
            ],
            [
                'name' => 'Gialli e Noir',
                'description' => 'Misteri da risolvere e storie noir avvincenti',
                'published_at' => now()->subYears(3),
            ],
            [
                'name' => 'Contemporanei',
                'description' => 'La narrativa del nostro tempo',
                'published_at' => now()->subYear(),
            ],
            [
                'name' => 'Horror e Thriller',
                'description' => 'Storie che ti terranno con il fiato sospeso',
                'published_at' => now()->subMonths(6),
            ],
        ];

        foreach ($collections as $collection) {
            Collection::create($collection);
        }

        // Crea altre 10 collezioni random con Factory
        Collection::factory(10)->create();
    }
}

