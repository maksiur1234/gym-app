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
        Schema::create('user_training_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->unsignedBigInteger('training_plan_id');

            $table->foreign('user_id') 
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('training_plan_id')
                  ->references('id')->on('training_plans')
                  ->onDelete('cascade');

            $table->primary(['user_id', 'training_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_training_plans');
    }
};
