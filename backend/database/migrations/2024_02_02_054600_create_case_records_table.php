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
            'case_records', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->date_time('datetime');
                $table->foreignId('patient_id')->constrained();
                $table->foreignId('doctor_id')->constrained();
                $table->text('text');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_records');
    }
};
