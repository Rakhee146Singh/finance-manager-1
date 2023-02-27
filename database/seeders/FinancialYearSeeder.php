<?php

namespace Database\Seeders;

use App\Models\FinancialYear;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\FinancialYear::factory(10)->create();
    }
}
