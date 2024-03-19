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
        Schema::create(
            'doctors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->foreignId('speciality_id')->constrained();
                $table->boolean('active')->default(true);
                $table->string('photo_url')->nullable();
                $table->time('workday_start')->default('08:00');
                $table->time('workday_end')->default('17:00');
                $table->time('lunch_start')->default('13:00');
                $table->time('lunch_end')->default('14:00');
                $table->string('appointment_duration')->default('PT30M');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
