<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        $now = now();

        return [
            'C_Name' => strtoupper($this->faker->company()),
            'smartaccess_active' => 1,
            'created_by' => 'SYSTEM',
            'C_Instruction' => $this->faker->sentence(),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
