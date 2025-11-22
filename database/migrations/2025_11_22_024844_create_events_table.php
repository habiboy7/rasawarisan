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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Pembuat event
            $table->unsignedBigInteger('partner_id')->nullable(); // Kalau partner yang bikin
            $table->unsignedBigInteger('region_id')->nullable(); // Daerah event
            $table->unsignedBigInteger('dish_id')->nullable(); // Makanan terkait

            // Info Event
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['lomba', 'festival', 'workshop', 'bazaar', 'pameran', 'lainnya'])->default('lainnya');
            $table->text('description');

            // Media
            $table->string('poster_url')->nullable();

            // Lokasi
            $table->string('location_name');
            $table->text('location_address');
            $table->decimal('location_lat', 10, 7)->nullable();
            $table->decimal('location_lng', 10, 7)->nullable();

            // Jadwal
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            // Ticket & Registration
            $table->decimal('ticket_price', 10, 2)->default(0); // 0 = gratis
            $table->integer('max_participants')->nullable();
            $table->string('registration_url')->nullable();

            // Organizer Contact
            $table->string('organizer_name');
            $table->string('organizer_email');
            $table->string('organizer_phone', 20);

            // Status & Approval
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'cancelled', 'completed'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_featured')->default(false);

            // Stats
            $table->integer('view_count')->default(0);

            // Approval info
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('partner_id')->references('id')->on('partners')->nullOnDelete();
            $table->foreign('region_id')->references('id')->on('regions')->nullOnDelete();
            $table->foreign('dish_id')->references('id')->on('dishes')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();

            // Indexes
            $table->index('status');
            $table->index('start_date');
            $table->index(['status', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
