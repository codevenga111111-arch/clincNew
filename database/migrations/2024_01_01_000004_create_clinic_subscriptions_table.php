<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_plan_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['active', 'cancelled', 'expired', 'suspended'])->default('active');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_subscriptions');
    }
};
