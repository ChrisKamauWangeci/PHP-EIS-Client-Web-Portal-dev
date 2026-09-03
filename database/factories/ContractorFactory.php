<?php

namespace Database\Factories;

use App\Models\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractorFactory extends Factory
{
    protected $model = Contractor::class;

    public function definition(): array
    {
        $now = now();

        return [
            'C_Name' => strtoupper($this->faker->name()),
            'C_Email' => $this->faker->unique()->safeEmail(),
            'C_Password' => 'Secret123!',
            'C_UserCompany' => 'EIS',
            'C_SysAdmin' => 0,
            'C_Caller' => 1,
            'access_files' => 1,
            'access_mfa' => 0,
            'accesslevel' => 1,
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
