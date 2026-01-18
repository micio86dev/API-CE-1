<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => ['it' => 'Fantasy', 'en' => 'Fantasy'], 'alias' => 'fantasy'],
            ['name' => ['it' => 'Giallo', 'en' => 'Mystery'], 'alias' => 'giallo'],
            ['name' => ['it' => 'Saggistica', 'en' => 'Non-fiction'], 'alias' => 'saggistica'],
            ['name' => ['it' => 'Romance', 'en' => 'Romance'], 'alias' => 'romance'],
            ['name' => ['it' => 'Horror', 'en' => 'Horror'], 'alias' => 'horror'],
            ['name' => ['it' => 'Thriller', 'en' => 'Thriller'], 'alias' => 'thriller'],
            ['name' => ['it' => 'Sci-Fi', 'en' => 'Sci-Fi'], 'alias' => 'sci-fi'],
            ['name' => ['it' => 'Biografico', 'en' => 'Biography'], 'alias' => 'biografico'],

            // Location/customer types you already had
            ['name' => ['it' => 'Negozio', 'en' => 'Shop'], 'alias' => 'shop'],
            ['name' => ['it' => 'Magazzino', 'en' => 'Warehouse'], 'alias' => 'warehouse'],
            ['name' => ['it' => 'Editore', 'en' => 'Publisher'], 'alias' => 'publisher'],
            ['name' => ['it' => 'Sede centrale', 'en' => 'Headquarters'], 'alias' => 'headquarters'],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}