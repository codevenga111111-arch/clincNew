<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'partial', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->date('due_date');
            $table->date('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index(['clinic_id', 'status']);
            $table->index(['clinic_id', 'patient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
