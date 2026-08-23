<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->date('prescription_date');
            $table->text('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index(['clinic_id', 'patient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
