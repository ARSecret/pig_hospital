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
            'appointments', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->dateTime('datetime');
                $table->foreignId('patient_id');
                $table->foreignId('doctor_id');
                $table->enum(
                    'status', [
                        'created', 'confirmed', 'cancelled', 'successful', 'didnt-come'
                    ],
                )->default('created');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};