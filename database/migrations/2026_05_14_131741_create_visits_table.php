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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignId('receptionist_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('status', [
                'waiting',
                'assigned',
                'in_progress',
                'done',
                'cancelled'
            ])->default('waiting');

            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
