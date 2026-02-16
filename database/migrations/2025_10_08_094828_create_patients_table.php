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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');  
            $table->string('email')->unique();
            $table->string('password');
            $table->date('date_of_birth');  
            $table->string('phone')->unique();
            $table->enum('gender', ['male', 'female']);   
            $table->string('blood_type')->nullable();
            $table->string('address')->nullable(); 
            $table->text('medical_history')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
