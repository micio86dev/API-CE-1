<?php
// FILE: database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Models\BaseModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypeSeeder::class,
            CollectionSeeder::class,
            AuthorSeeder::class,
            CustomerSeeder::class,
            LocationSeeder::class,
            BookSeeder::class,
        ]);
    }
}