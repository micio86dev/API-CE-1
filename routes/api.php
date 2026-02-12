<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['audit.log', 'set.lang'])->group(function () {
    Route::controller(AuthController::class)->name('login')->group(function () {
        Route::post('login', 'login')->name('.login');
    });
    Route::middleware(['auth.jwt'])->group(function () {

        // addresses routes
        $prefix = 'addresses';
        Route::controller(AddressController::class)
            ->prefix($prefix)
            ->name($prefix)
            ->group(function () use ($prefix) {
                Route::get('', 'index')->name('.index')->middleware("permission:$prefix.index");
                Route::get('{id}', 'show')->name('.show')->middleware("permission:$prefix.show");
                Route::post('', 'store')->name('.store')->middleware("permission:$prefix.store");
                Route::put('{id}', 'update')->name('.update')->middleware("permission:$prefix.update");
                Route::delete('{id}', 'destroy')->name('.destroy')->middleware("permission:$prefix.destroy");
            });

        //authors routes
        $prefix = 'authors';
        Route::controller(AuthorController::class)
            ->prefix($prefix)
            ->name($prefix)
            ->group(function () use ($prefix) {
                Route::get('', 'index')->name('.index')->middleware("permission:$prefix.index");
                Route::get('{id}', 'show')->name('.show')->middleware("permission:$prefix.show");
                Route::post('', 'store')->name('.store')->middleware("permission:$prefix.store");
                Route::put('{id}', 'update')->name('.update')->middleware("permission:$prefix.update");
                Route::delete('{id}', 'destroy')->name('.destroy')->middleware("permission:$prefix.destroy");
            });

        // books routes
        Route::controller(BookController::class)
            ->prefix('books')
            ->name('books')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:books.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:books.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:books.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:books.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:books.destroy');
            });
        // addresses routes
        $prefix = 'books_quantity';
        Route::controller(BookQuantityController::class)
            ->prefix($prefix)
            ->name($prefix)
            ->group(function () use ($prefix) {
                Route::patch('', 'moveBooks')->name('.move_books')->middleware("permission:$prefix.move_books");
                Route::patch('', 'cancelMoveBooks')->name('.cancel_move_books')->middleware("permission:$prefix.move_books");
            });

        // collections routes
        Route::controller(CollectionController::class)
            ->prefix('collections')
            ->name('collections')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:collections.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:collections.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:collections.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:collections.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:collections.destroy');
            });

        // customers routes
        Route::controller(CustomerController::class)
            ->prefix('customers')
            ->name('customers')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:customers.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:customers.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:customers.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:customers.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:customers.destroy');
            });

        // locations routes
        Route::controller(LocationController::class)
            ->prefix('locations')
            ->name('locations')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:locations.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:locations.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:locations.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:locations.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:locations.destroy');
            });

        // types routes
        Route::controller(TypeController::class)
            ->prefix('types')
            ->name('types')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:types.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:types.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:types.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:types.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:types.destroy');
            });

        // users routes (only admin)
        Route::controller(UserController::class)
            ->prefix('users')
            ->name('users')
            ->middleware('permission:users.index')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:users.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:users.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:users.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:users.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:users.destroy');
            });
    });
});
