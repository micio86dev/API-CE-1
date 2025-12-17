<?php
// FILE: database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Models\BaseModel;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{   
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('roles:permissions');
        $this->call([
            TypeSeeder::class,
            CollectionSeeder::class,
            AuthorSeeder::class,
            CustomerSeeder::class,
            LocationSeeder::class,
            BookSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}