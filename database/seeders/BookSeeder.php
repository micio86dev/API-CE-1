<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Collection;
use App\Models\Type;
use App\Models\Location;
use app\Models\BaseModel;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $collections = Collection::all();
        $authors = Author::all();
        $locations = Location::all();
        
        // Types per i libri (non location types)
        $bookTypes = Type::whereIn('alias', [
            'fantasy', 'giallo', 'saggistica', 'romance', 'horror', 'thriller', 'sci-fi', 'biografico'
        ])->get();

        // Crea 100 libri
        Book::factory(100)->create()->each(function ($book) use ($authors, $bookTypes, $locations) {
            // Assegna 1-3 autori random a ogni libro
            $randomAuthors = $authors->random(rand(1, 3));
            $book->authors()->attach($randomAuthors->pluck('id'));

            // Assegna 1-2 types (generi) a ogni libro
            $randomTypes = $bookTypes->random(rand(1, 2));
            $book->types()->attach($randomTypes->pluck('id'));

            // Assegna quantità random in 2-6 locations
            $randomLocations = $locations->random(rand(2, 6));
            foreach ($randomLocations as $location) {
                $book->locations()->attach($location->id, [
                    'quantity' => rand(0, 150)
                ]);
            }
        });

        // Crea alcuni libri specifici famosi
        $this->createFamousBooks($authors, $bookTypes, $locations);
    }

    private function createFamousBooks($authors, $bookTypes, $locations)
    {
        $famousBooks = [
            [
                'title' => 'Il Signore degli Anelli',
                'price' => 25.90,
                'plot' => 'Un\'epica avventura fantasy che narra la storia dell\'Anello del Potere e della missione per distruggerlo.',
                'author_name' => 'Tolkien',
                'type' => 'fantasy',
                'collection' => 'Fantasy Epico',
            ],
            [
                'title' => 'Lo Hobbit',
                'price' => 18.50,
                'plot' => 'La storia di Bilbo Baggins e della sua avventura inaspettata.',
                'author_name' => 'Tolkien',
                'type' => 'fantasy',
                'collection' => 'Fantasy Epico',
            ],
            [
                'title' => 'It',
                'price' => 22.00,
                'plot' => 'Un gruppo di ragazzi affronta le proprie paure incarnate in una creatura terrificante.',
                'author_name' => 'King',
                'type' => 'horror',
                'collection' => 'Horror e Thriller',
            ],
            [
                'title' => 'Assassinio sull\'Orient Express',
                'price' => 15.50,
                'plot' => 'Hercule Poirot indaga su un omicidio avvenuto sul lussuoso treno Orient Express.',
                'author_name' => 'Christie',
                'type' => 'giallo',
                'collection' => 'Gialli e Noir',
            ],
        ];

        foreach ($famousBooks as $bookData) {
            $author = $authors->firstWhere('last_name', $bookData['author_name']);
            $type = $bookTypes->firstWhere('alias', $bookData['type']);
            $collection = Collection::where('name', 'like', '%' . $bookData['collection'] . '%')->first();

            if ($author && $type && $collection) {
                $book = Book::create([
                    'title' => $bookData['title'],
                    'price' => $bookData['price'],
                    'plot' => $bookData['plot'],
                    'published_at' => now()->subYears(rand(10, 50)),
                    'collection_id' => $collection->id,
                ]);

                $book->authors()->attach($author->id);
                $book->types()->attach($type->id);

                // Aggiungi quantità in diverse locations
                $randomLocations = $locations->random(rand(3, 8));
                foreach ($randomLocations as $location) {
                    $book->locations()->attach($location->id, [
                        'quantity' => rand(5, 200)
                    ]);
                }
            }
        }
    }
}
