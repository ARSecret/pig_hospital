<?php

use App\Models\Enums\AppointmentStatus;
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
            'appointments',
            function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->dateTime('date_time');
                $table->foreignId('patient_id')->constrained();
                $table->foreignId('doctor_id')->constrained();
                $table->enum(
                    'status',
                    array_map(
                        fn ($case) => $case->value, AppointmentStatus::cases())
                )->default(AppointmentStatus::Created);
                $table->boolean('is_online')->default(false);
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
