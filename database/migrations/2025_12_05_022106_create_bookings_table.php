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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // ─── Foreign keys ───
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                  ->constrained('doctors')
                  ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->nullOnDelete();
                
            // ─── Appointment details ───
            $table->date('appointment_date');
            $table->time('appointment_time');

            // ─── Payment ───
            $table->enum('payment_method', ['card', 'at_clinic'])
                    ->default('at_clinic');

            $table->decimal('amount', 10, 2)->default(0);

            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                  ->default('pending');

            // card fields (nullable — only filled when payment_method = 'card')
            $table->string('card_name')->nullable();
            $table->string('card_last4', 4)->nullable();   // store only last 4 digits
            $table->string('card_expiry', 7)->nullable();  // MM / YY


            // ─── Booking status ───
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
                  ->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // ─── Indexes ───
            $table->unique(
                ['doctor_id', 'appointment_date', 'appointment_time'],
                'doctor_slot_unique'
            );

            $table->index(['doctor_id', 'appointment_date', 'appointment_time']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
