<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('has_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type', 60);
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade');
            
            $table->unique(['model_id', 'model_type', 'type_id'], 'idx_morph_composite');
            $table->index('model_id', 'idx_morph_model_id');
            $table->index('model_type', 'idx_morph_model_type');
            $table->index('type_id', 'idx_morph_type_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('has_types');
    }
};

