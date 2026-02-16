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
        Schema::create('invoices', function (Blueprint $table) {
        $table->id();

        // المريض اللي تخصه الفاتورة
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');

        // الدكتور اللي كشف على المريض
        $table->foreignId('doctor_id')->constrained()->onDelete('cascade');

        // اليوزر اللي أنشأ الفاتورة (ممكن يكون Admin أو Receptionist)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // سعر الكشف أو الخدمة
        $table->decimal('amount', 8, 2);

        // حالة الدفع
        $table->enum('status', ['paid', 'unpaid'])->default('unpaid');

        // ملاحظات اختيارية
        $table->text('notes')->nullable();

        // تاريخ الفاتورة
        $table->date('invoice_date')->default(now());
        $table->softDeletes();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
