<?php

namespace Database\Seeders;

use App\Models\CaseRecord;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaseRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::all()->each(function (Patient $patient) {
            CaseRecord::factory()->count(12)->for($patient)->create();
        });
    }
}
