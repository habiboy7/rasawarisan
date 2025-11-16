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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('region_id'); // provinsi asal
            $table->string('short_description')->nullable();
            $table->text('history')->nullable();
            $table->text('recipe')->nullable(); // bisa disimpan JSON nantinya
            $table->string('main_image_url')->nullable();

            $table->integer('popularity_score')->default(0);
            $table->integer('likes_count')->default(0);

            $table->timestamps();

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
