<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pregnancy_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregnancy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->integer('week_number');
            $table->date('exam_date');
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->decimal('blood_pressure_systolic', 5, 1)->nullable();
            $table->decimal('blood_pressure_diastolic', 5, 1)->nullable();
            $table->decimal('fundal_height_cm', 5, 1)->nullable();
            $table->decimal('fetal_heart_rate', 5, 1)->nullable();
            $table->decimal('weight_fetus_grams', 7, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['pregnancy_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pregnancy_exams');
    }
};
