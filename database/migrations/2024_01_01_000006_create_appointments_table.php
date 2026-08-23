<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('appointment_date');
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->string('type')->nullable();
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->integer('duration_minutes')->default(30);
            $table->timestamps();

            $table->index(['clinic_id', 'appointment_date']);
            $table->index(['doctor_id', 'appointment_date']);
            $table->index(['patient_id', 'appointment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
