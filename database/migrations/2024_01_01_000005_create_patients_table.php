<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('national_id')->nullable();
            $table->text('address')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('allergies')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['clinic_id', 'name']);
            $table->index(['clinic_id', 'phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
