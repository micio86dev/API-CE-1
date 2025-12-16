<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->name('login')->group(function () {
        Route::post('login', 'login')->name('.login');
    });
    Route::middleware(['auth.jwt'])->group(function () {

        // addresses routes
        Route::controller(AddressController::class)
            ->prefix('addresses')
            ->name('addresses')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:addresses.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:addresses.show');
                Route::post('', 'store')
                    ->name('.store')
                    ->middleware('permission:addresses.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:addresses.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:addresses.destroy');
            });

        //authors routes
        Route::controller(AuthorController::class)
            ->prefix('authors')
            ->name('authors')
            ->group(function () {
                Route::get('', 'index')
                    ->name('.index')
                    ->middleware('permission:authors.index');
                Route::get('{id}', 'show')
                    ->name('.show')
                    ->middleware('permission:authors.show');
                Route::post('', 'store')
                    ->name('.store')
                        ->middleware('permission:authors.store');
                Route::put('{id}', 'update')
                    ->name('.update')
                    ->middleware('permission:authors.update');
                Route::delete('{id}', 'destroy')
                    ->name('.destroy')
                    ->middleware('permission:authors.destroy');
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
