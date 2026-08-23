<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->default('patient')->after('name');
            $table->foreignId('clinic_id')->nullable()->after('user_type');
            $table->string('phone')->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'clinic_id', 'phone', 'is_active']);
        });
    }
};
