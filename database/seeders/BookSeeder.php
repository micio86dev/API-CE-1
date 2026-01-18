<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Collection;
use App\Models\Location;
use App\Models\Type;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

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

        $fakerIt = FakerFactory::create('it_IT');
        $fakerEn = FakerFactory::create('en_US');

        // Crea 100 libri (without factory so JSON translations are explicit)
        for ($i = 0; $i < 100; $i++) {
            $titleIt = $fakerIt->sentence(rand(2, 5));
            $titleEn = $fakerEn->sentence(rand(2, 5));

            $plotIt = $fakerIt->optional(0.9)->paragraph(3);
            $plotEn = $plotIt ? $fakerEn->paragraph(3) : null;

            $book = Book::create([
                'title' => ['it' => $titleIt, 'en' => $titleEn],
                'price' => $fakerIt->randomFloat(2, 5, 50),
                'plot' => $plotIt ? ['it' => $plotIt, 'en' => $plotEn] : null,
                'published_at' => $fakerIt->dateTimeBetween('-50 years', '-1 year'),
                'collection_id' => $collections->isNotEmpty() ? $collections->random()->id : null,
            ]);

            // Assegna 1-3 autori random a ogni libro
            if ($authors->isNotEmpty()) {
                $randomAuthors = $authors->random(min($authors->count(), rand(1, 3)));
                $book->authors()->attach($randomAuthors->pluck('id'));
            }

            // Assegna 1-2 types (generi) a ogni libro
            if ($bookTypes->isNotEmpty()) {
                $randomTypes = $bookTypes->random(min($bookTypes->count(), rand(1, 2)));
                $book->types()->attach($randomTypes->pluck('id'));
            }

            // Assegna quantità random in 2-6 locations
            if ($locations->isNotEmpty()) {
                $randomLocations = $locations->random(min($locations->count(), rand(2, 6)));
                foreach ($randomLocations as $location) {
                    $book->locations()->attach($location->id, ['quantity' => rand(0, 150)]);
                }
            }
        }

        // Crea alcuni libri specifici famosi
        $this->createFamousBooks($authors, $bookTypes, $locations);
    }

    private function createFamousBooks($authors, $bookTypes, $locations): void
    {
        $famousBooks = [
            [
                'title' => ['it' => 'Il Signore degli Anelli', 'en' => 'The Lord of the Rings'],
                'price' => 25.90,
                'plot' => [
                    'it' => 'Un\'epica avventura fantasy che narra la storia dell\'Anello del Potere e della missione per distruggerlo.',
                    'en' => 'An epic fantasy adventure about the One Ring and the quest to destroy it.',
                ],
                'author_name' => 'Tolkien',
                'type' => 'fantasy',
                'collection_it' => 'Fantasy Epico',
            ],
            [
                'title' => ['it' => 'Lo Hobbit', 'en' => 'The Hobbit'],
                'price' => 18.50,
                'plot' => ['it' => 'La storia di Bilbo Baggins e della sua avventura inaspettata.', 'en' => 'Bilbo Baggins and his unexpected journey.'],
                'author_name' => 'Tolkien',
                'type' => 'fantasy',
                'collection_it' => 'Fantasy Epico',
            ],
            [
                'title' => ['it' => 'It', 'en' => 'It'],
                'price' => 22.00,
                'plot' => ['it' => 'Un gruppo di ragazzi affronta le proprie paure incarnate in una creatura terrificante.', 'en' => 'A group of kids faces their fears made real by a terrifying entity.'],
                'author_name' => 'King',
                'type' => 'horror',
                'collection_it' => 'Horror e Thriller',
            ],
            [
                'title' => ['it' => 'Assassinio sull\'Orient Express', 'en' => 'Murder on the Orient Express'],
                'price' => 15.50,
                'plot' => ['it' => 'Hercule Poirot indaga su un omicidio avvenuto sul lussuoso treno Orient Express.', 'en' => 'Hercule Poirot investigates a murder aboard the luxurious Orient Express.'],
                'author_name' => 'Christie',
                'type' => 'giallo',
                'collection_it' => 'Gialli e Noir',
            ],
        ];

        foreach ($famousBooks as $bookData) {
            $author = $authors->firstWhere('last_name', $bookData['author_name']);
            $type = $bookTypes->firstWhere('alias', $bookData['type']);

            // JSON column query: match Italian translation
            $collection = Collection::where('name->it', $bookData['collection_it'])->first();

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

                if ($locations->isNotEmpty()) {
                    $randomLocations = $locations->random(min($locations->count(), rand(3, 8)));
                    foreach ($randomLocations as $location) {
                        $book->locations()->attach($location->id, ['quantity' => rand(5, 200)]);
                    }
                }
            }
        }
    }
}