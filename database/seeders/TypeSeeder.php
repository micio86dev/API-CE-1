<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;
use app\Models\BaseModel;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Fantasy', 'alias' => 'fantasy'],
            ['name' => 'Giallo', 'alias' => 'giallo'],
            ['name' => 'Saggistica', 'alias' => 'saggistica'],
            ['name' => 'Romance', 'alias' => 'romance'],
            ['name' => 'Horror', 'alias' => 'horror'],
            ['name' => 'Thriller', 'alias' => 'thriller'],
            ['name' => 'Sci-Fi', 'alias' => 'sci-fi'],
            ['name' => 'Biografico', 'alias' => 'biografico'],
            ['name' => 'Shop', 'alias' => 'shop'],
            ['name' => 'Warehouse', 'alias' => 'warehouse'],
            ['name' => 'Publisher', 'alias' => 'publisher'],
            ['name' => 'Headquarters', 'alias' => 'headquarters'],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
