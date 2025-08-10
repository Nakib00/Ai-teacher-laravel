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
        Schema::create('report_models', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id'); // Student
    $table->unsignedBigInteger('topic_id');
    $table->unsignedBigInteger('teacher_id')->nullable(); // Optional, if AI/teacher is assigned

    $table->text('note')->nullable();

    // Points tracking
    $table->integer('interaction_points')->default(0);
    $table->integer('answer_points')->default(0);
    $table->integer('time_points')->default(0);
    $table->integer('discussion_points')->default(0);
    $table->integer('total_points')->default(0);

    $table->boolean('is_active')->default(true);

    // Optional: track start and end times of session
    $table->timestamp('session_started_at')->nullable();
    $table->timestamp('session_ended_at')->nullable();

    // Optional: store AI feedback or summary
    $table->text('feedback')->nullable();

    $table->timestamps();

    // Foreign keys (optional but recommended)
    // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    // $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
    // $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_models');
    }
};
