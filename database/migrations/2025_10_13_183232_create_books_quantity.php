<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books_quantity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->timestamps();
            
            $table->unique(['book_id', 'location_id'], 'unique_book_location');
            $table->index('book_id', 'idx_book_id');
            $table->index('location_id', 'idx_location_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books_quantity');
    }
};
