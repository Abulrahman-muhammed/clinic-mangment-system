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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->text('bio')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->decimal('consultation_fee', 8, 2)->nullable();
            $table->integer('years_of_experience')->nullable(); // عدد سنين الخبرة
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
