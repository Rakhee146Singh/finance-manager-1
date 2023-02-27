<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FinancialYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::createFromFormat('Y', $this->faker->year);
        $endDate = $startDate->addYear();

        return [
            'id' => Str::uuid()->toString(),
            'year' => $startDate->year,
            'start_date' =>  $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'is_active' => fake()->boolean()
            //     'year' => '2022-2023',
            //     'start_date' => '2022-01-04',
            //     'end_date' => '2023-01-04',
            //     'is_active' => true,
        ];
    }
}
