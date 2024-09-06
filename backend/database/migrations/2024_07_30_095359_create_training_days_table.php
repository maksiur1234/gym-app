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
        Schema::create('training_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_plan_id')->default(0);
            $table->unsignedBigInteger('ready_training_plan_id')->default(0);

            $table->foreign('training_plan_id')->references('id')->on('training_plans')->onDelete('cascade');
            $table->foreign('ready_training_plan_id')->references('id')->on('ready_training_plans')->onDelete('cascade');

            $table->string('day_name');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_days');
    }
};
