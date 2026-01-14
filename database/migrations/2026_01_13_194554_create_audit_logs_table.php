<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->uuid('request_id')->index();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guard', 20)->nullable(); // e.g. "api"

            $table->string('method', 10); // GET, POST, PUT, DELETE, etc.
            $table->text('path'); // e.g. /api/books/12
            $table->string('route_name')->nullable(); // e.g. books.show
            $table->string('action')->nullable(); // e.g. App\Http\Controllers\BookController@show

            $table->unsignedSmallInteger('status_code')->nullable();

            $table->string('ip', 45)->nullable(); // IPv4/IPv6
            $table->text('user_agent')->nullable();

            $table->unsignedInteger('duration_ms')->nullable();

            $table->string('error_class')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['route_name']);
            $table->index(['status_code']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};