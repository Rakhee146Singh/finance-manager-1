<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use App\Models\FinancialYear;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        FinancialYear::create([
            'id' => Str::uuid()->toString(),
            'year' => '2022-2023',
            'start_date' => '2022-01-04',
            'end_date' => '2023-01-04',
            'is_active' => true,
        ]);
    }
}
