<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pregnancy_week_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('week_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('baby_development')->nullable();
            $table->text('mother_changes')->nullable();
            $table->text('tips')->nullable();
            $table->text('warnings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pregnancy_week_contents');
    }
};
