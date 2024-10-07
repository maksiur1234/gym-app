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
        Schema::create('training_day_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_day_id')->constrained()->onDelete('cascade');
            $table->string('exercise_name');
            $table->integer('sets');
            $table->integer('reps');
            $table->integer('rir');
            $table->string('tempo');
            $table->string('break');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_day_exercises');
    }
};
