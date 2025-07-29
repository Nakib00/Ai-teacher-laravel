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
        Schema::create('class_books', function (Blueprint $table) {
            $table->id();
            // Add book_name column
            $table->string('book_name');
            // Add description column, allowing it to be null
            $table->text('description')->nullable();
            // Add is_active column with a default value of true
            $table->boolean('is_active')->default(true);
            // Add medium column (e.g., 'Bengali', 'English')
            $table->string('medium');
            // Add class_id as a foreign key
            $table->foreignId('class_id')
                  ->constrained('school_classes') // Assumes 'school_classes' table exists
                  ->onDelete('cascade'); // Optional: define behavior on parent deletion
            // Add school_id as a nullable foreign key
            // Assumes 'schools' table exists or will be created
            $table->foreignId('school_id')
                  ->nullable()
                  ->constrained('schools') // Assumes 'schools' table exists
                  ->onDelete('set null'); // Optional: define behavior on parent deletion
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
        Schema::dropIfExists('class_books');
    }
};