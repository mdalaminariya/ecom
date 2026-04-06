<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('blog_id')->constrained()->cascadeOnDelete();

            // Nullable for guest comments
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();

            // Guest info
            $table->string('name')->nullable();
            $table->string('email')->nullable();

            // Main comment
            $table->text('message');

            // Reply system
            $table->foreignId('parent_id')->nullable()->constrained('blog_comments')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
