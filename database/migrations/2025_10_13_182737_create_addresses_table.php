<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('city', 100);
            $table->string('province', 3);
            $table->string('country', 100);
            $table->string('street', 255);
            $table->string('street_number', 60);
            $table->string('zip', 7);
            $table->float('lat');
            $table->float('lng');
            $table->morphs('model'); // Creates model_id and model_type
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('country');
            $table->index('province');
            $table->index('city');
            $table->index('zip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
