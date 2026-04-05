<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->string('name');
        $table->string('email')->nullable();
        $table->text('message');
        $table->unsignedBigInteger('parent_id')->nullable();
        $table->decimal('rating', 2, 1)->default(0); // remove 'after' clause
        $table->timestamps(); // creates `created_at` and `updated_at`
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
