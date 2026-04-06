<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {

            // Make user_id nullable
            $table->foreignId('user_id')->nullable()->change();

            // Add guest fields
            if (!Schema::hasColumn('blog_comments', 'name')) {
                $table->string('name')->nullable();
            }

            if (!Schema::hasColumn('blog_comments', 'email')) {
                $table->string('email')->nullable();
            }

            // Rename comment -> message (BEST OPTION)
            if (Schema::hasColumn('blog_comments', 'comment')) {
                $table->renameColumn('comment', 'message');
            }

            // Reply system
            if (!Schema::hasColumn('blog_comments', 'parent_id')) {
                $table->foreignId('parent_id')
                      ->nullable()
                      ->constrained('blog_comments')
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {

            // Reverse parent_id
            if (Schema::hasColumn('blog_comments', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }

            // Reverse rename
            if (Schema::hasColumn('blog_comments', 'message')) {
                $table->renameColumn('message', 'comment');
            }

            // Drop guest fields
            $table->dropColumn(['name', 'email']);

            // Make user_id NOT nullable again
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
