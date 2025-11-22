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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // SEO friendly URL
            $table->enum('type', ['pulau', 'provinsi', 'kabupaten'])->default('provinsi');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('center_lat', 10, 7)->nullable();
            $table->decimal('center_lng', 10, 7)->nullable();
            $table->json('geojson')->nullable(); // untuk boundary peta
            $table->timestamps();

            $table->index(['type', 'parent_id']);
        });

        // foreign key self-reference
        Schema::table('regions', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('regions')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        
        Schema::dropIfExists('regions');
    }
};
