<?php

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('cache.redis_model.enabled', true);
    config()->set('cache.stores.ttl', [
        'driver' => 'array',
        'serialize' => false,
    ]);
    config()->set('cache.stores.persistent', [
        'driver' => 'array',
        'serialize' => false,
    ]);

    Cache::store('ttl')->flush();
    Cache::store('persistent')->flush();

    app()->setLocale('en');
    $this->withoutMiddleware();
});

it('serves show from cache on second request', function () {
    $book = Book::factory()->create();

    $countQueries = function (Closure $request): int {
        DB::flushQueryLog();
        DB::enableQueryLog();
        $request();
        $queries = count(DB::getQueryLog());
        DB::disableQueryLog();

        return $queries;
    };

    $firstQueries = $countQueries(function () use ($book) {
        $this->getJson("/api/v1/books/{$book->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $book->id);
    });

    $secondQueries = $countQueries(function () use ($book) {
        $this->getJson("/api/v1/books/{$book->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $book->id);
    });

    expect($firstQueries)->toBeGreaterThan(0);
    expect($secondQueries)->toBeLessThan($firstQueries);
});

it('uses deterministic index keying for same semantic query', function () {
    Book::factory()->count(3)->create();

    $countQueries = function (Closure $request): int {
        DB::flushQueryLog();
        DB::enableQueryLog();
        $request();
        $queries = count(DB::getQueryLog());
        DB::disableQueryLog();

        return $queries;
    };

    $firstQueries = $countQueries(function () {
        $this->getJson('/api/v1/books?perpage=2&page=1')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    });

    $secondQueries = $countQueries(function () {
        $this->getJson('/api/v1/books?page=1&perpage=2')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    });

    expect($firstQueries)->toBeGreaterThan(0);
    expect($secondQueries)->toBeLessThan($firstQueries);
});

it('keeps show and index consistent after update', function () {
    $book = Book::factory()->create([
        'title' => ['en' => 'Original title', 'it' => 'Titolo originale'],
    ]);

    $this->getJson("/api/v1/books/{$book->id}")->assertOk();
    $this->getJson('/api/v1/books?perpage=10&page=1')->assertOk();

    $this->putJson("/api/v1/books/{$book->id}", [
        'title' => 'Updated title',
    ])->assertOk()->assertJsonPath('data.title', 'Updated title');

    $this->getJson("/api/v1/books/{$book->id}")
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated title');

    $this->getJson('/api/v1/books?perpage=10&page=1')
        ->assertOk()
        ->assertJsonPath('data.0.id', $book->id)
        ->assertJsonPath('data.0.title', 'Updated title');
});
