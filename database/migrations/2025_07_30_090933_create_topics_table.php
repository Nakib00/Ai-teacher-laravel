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
        Schema::create('topics', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key

            $table->string('topic_title'); // For the title of the topic (e.g., "Introduction to Nouns")
            $table->text('description')->nullable(); // Detailed explanation of the topic, can be null
            $table->boolean('is_active')->default(true); // Whether the topic is currently active/visible in the app
            $table->string('type')->nullable(); // E.g., 'lesson', 'quiz', 'exercise'. Useful for categorization.
            $table->text('note')->nullable(); // Any internal notes about the topic, not for display to students
            $table->integer('points')->default(0); // Points associated with completing this topic

            // Foreign keys for relationships (initially nullable as you suggested)
            // It's generally better to make them non-nullable if a topic *must* belong to a chapter, subject, or class.
            // But if you're building out gradually, nullable is fine for now.

            // Using unsignedBigInteger for foreign keys is standard as 'id()' creates a big integer.
            $table->foreignId('chapter_id')
                  ->nullable() // Can be null if a topic exists independently or before chapter assignment
                  ->constrained() // Assumes a 'chapters' table exists or will be created
                  ->onDelete('set null'); // If a chapter is deleted, set this to null, don't delete the topic

            $table->foreignId('subject_id')
                  ->nullable() // Can be null
                  ->constrained() // Assumes a 'subjects' table
                  ->onDelete('set null');

            $table->foreignId('class_id')
                  ->nullable() // Can be null
                  ->constrained() // Assumes a 'classes' table
                  ->onDelete('set null');

            $table->timestamps(); // `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};