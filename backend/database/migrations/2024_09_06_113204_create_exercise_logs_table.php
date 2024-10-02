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
        Schema::create('exercise_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workout_session_id');
            $table->unsignedBigInteger('exercise_id');
            $table->integer('sets_done');
            $table->integer('reps_done');
            $table->integer('weight_used')->nullable();
            $table->text('notes')->nullable();
            $table->foreign('workout_session_id')->references('id')->on('workout_sessions')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_logs');
    }
};
