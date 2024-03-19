<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialityNames = ['терапевт', 'окулист', 'кардиолог', 'педиатр', 'аллерголог'];

        foreach ($specialityNames as $specialityName) {
            DB::table('specialities')->insert([
                'name' => $specialityName,
                'description' => fake()->text(200),
            ]);
        }
    }
}
