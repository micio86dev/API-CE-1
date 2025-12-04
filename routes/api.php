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
    
    //protected routes
    Route::middleware(['auth.jwt'])->group(function () { 
        Route::controller(AuthController::class)->name('auth')->group(function () {
            Route::post('logout', 'logout')->name('.logout');
            Route::post('refresh', 'refresh')->name('.refresh');
            Route::post('me', 'me')->name('.me');
        });

        Route::controller(AuthorController::class)->prefix('authors')->name('authors')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });

        Route::controller(CustomerController::class)->prefix('customers')->name('customers')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });

        Route::controller(LocationController::class)->prefix('locations')->name('locations')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });

        Route::controller(CollectionController::class)->prefix('collections')->name('collections')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });

        Route::controller(TypeController::class)->prefix('types')->name('types')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });

        Route::controller(AddressController::class)->prefix('addresses')->name('addresses')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });

        Route::controller(BookController::class)->prefix('books')->name('books')->group(function () {
            Route::post('', 'store')->name('.store');
            Route::put('{id}', 'update')->name('.update');
            Route::delete('{id}', 'destroy')->name('.destroy');
        });
    });

    Route::controller(AuthorController::class)->prefix('authors')->name('authors')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(CustomerController::class)->prefix('customers')->name('customers')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(LocationController::class)->prefix('location')->name('locations')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(CollectionController::class)->prefix('collection')->name('collections')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(TypeController::class)->prefix('type')->name('types')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(AddressController::class)->prefix('address')->name('addresses')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(BookController::class)->prefix('book')->name('books')->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{id}', 'show')->name('.show');
    });

    Route::controller(UserController::class)->prefix('user')->name('users')->group(function () {
        Route::post('', 'store')->name('.store');
    });
});
