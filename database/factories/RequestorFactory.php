<?php

namespace Database\Factories;

use App\Models\Requestor;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestorFactory extends Factory
{
    protected $model = Requestor::class;

    public function definition(): array
    {
        $now = now();

        return [
            'R_Name' => 'REQ_' . strtoupper($this->faker->lexify('????')),
            'R_Company' => 'EXPRESS IMAGING SERVICES',
            'R_Email' => $this->faker->safeEmail(),
            'R_Active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
