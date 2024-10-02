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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->integer('level');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->integer('required_global_level')->default(0);
            $table->integer('required_category_level')->default(0);
            $table->string('img_path')->nullable();
            $table->string('exercise_type')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
