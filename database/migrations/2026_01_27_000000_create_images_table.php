<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            // Polymorphic owner (Book/Author/Location/Customer/...)
            // Nullable to allow "upload first, attach later" workflow.
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type', 60)->nullable();

            // Storage details
            $table->string('disk', 32)->default('local');
            $table->string('path');

            // Metadata
            $table->string('original_name')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->json('meta')->nullable();

            // Ordering / selection helpers
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['model_id', 'model_type'], 'idx_images_morph');
            $table->index(['disk', 'path'], 'idx_images_disk_path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};

