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
        Schema::create('chapter_books', function (Blueprint $table) {
            $table->id();
            // Add chapter_name column
            $table->string('chapter_name');
            // Add book_id as a foreign key
            $table->foreignId('book_id')
                  ->constrained('class_books') // Assumes 'class_books' table exists
                  ->onDelete('cascade'); // If the parent book is deleted, delete associated chapters
            // Add description column, allowing it to be null
            $table->text('description')->nullable();
            // Add is_active column with a default value of true
            $table->boolean('is_active')->default(true);
            // Add ai_added column with a default value of false
            $table->boolean('ai_added')->default(false);
            // Add image_url column, allowing it to be null
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapter_books');
    }
};