<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use app\Models\BaseModel;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        // Autori famosi predefiniti
        $famousAuthors = [
            ['first_name' => 'J.R.R.', 'last_name' => 'Tolkien'],
            ['first_name' => 'George R.R.', 'last_name' => 'Martin'],
            ['first_name' => 'Stephen', 'last_name' => 'King'],
            ['first_name' => 'Agatha', 'last_name' => 'Christie'],
            ['first_name' => 'Ernest', 'last_name' => 'Hemingway'],
            ['first_name' => 'Jane', 'last_name' => 'Austen'],
            ['first_name' => 'Gabriel García', 'last_name' => 'Márquez'],
            ['first_name' => 'Haruki', 'last_name' => 'Murakami'],
            ['first_name' => 'Umberto', 'last_name' => 'Eco'],
            ['first_name' => 'Italo', 'last_name' => 'Calvino'],
        ];

        foreach ($famousAuthors as $author) {
            Author::create($author);
        }

        // Crea altri 40 autori random
        Author::factory(40)->create();
    }
}