<?php

namespace Database\Factories;

use App\Models\Workorder;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkorderFactory extends Factory
{
    protected $model = Workorder::class;

    public function definition(): array
    {
        $now = now();

        return [
            'W_Status'          => $this->faker->randomElement(['Incomplete', 'Complete', 'Cancel']),
            'W_Requestor'       => 'REQ_ADMIN',
            'W_Contractor'      => 'ANDRAS KENDE',
            'W_BillCompany'     => 'EXPRESS IMAGING SERVICES',
            'W_Owner'           => 'ANDRAS KENDE',
            'W_Urgent'          => $this->faker->boolean(20) ? 1 : 0,
            'W_FirstName'       => $this->faker->firstName(),
            'W_MiddleInit'      => strtoupper($this->faker->lexify('?')),
            'W_LastName'        => $this->faker->lastName(),
            'W_SS'              => $this->faker->numerify('###-##-####'),
            'W_DOB'             => $this->faker->dateTimeBetween('-70 years', '-18 years'),
            'W_Gender'          => $this->faker->randomElement(['M', 'F']),
            'W_YearsOfRecord'   => $this->faker->randomElement(['1 Year', '3 Years', '5 Years', 'Entire Chart']),
            'W_Hospital'        => $this->faker->company() . ' Hospital',
            // W_HospitalID intentionally excludes '10' and '69': WorkorderController::show()
            // switches the StatusList lookup to Type='G' (10) / Type='N' (69), and eisuat's
            // StatusList only has Type='S'/'F' rows seeded so far. Using 10/69 here produces
            // work orders whose "Status Note" dropdown renders empty. Re-add them once real
            // Type='G'/Type='N' StatusList rows are pulled from production and seeded.
            'W_HospitalID'      => $this->faker->randomElement(['88', '90']),
            'W_DrFee'           => $this->faker->randomFloat(2, 25, 100),
            'W_DrFee1'          => $this->faker->randomFloat(2, 10, 50),
            'W_DrFee2'          => $this->faker->randomFloat(2, 10, 50),
            'W_ShipFee'         => $this->faker->randomFloat(2, 5, 20),
            'W_ShipFee1'        => $this->faker->randomFloat(2, 5, 15),
            'W_ShipFee2'        => $this->faker->randomFloat(2, 5, 15),
            'W_Tracking1'       => $this->faker->bothify('1Z9999999999999###'),
            'W_Tracking2'       => $this->faker->bothify('1Z9999999999999###'),
            'W_Note'            => $this->faker->sentence(),
            'W_FollowUpStatus'  => 'INITIAL ORDER CREATED (' . $now->format('m-d-Y g:i:s A') . ')',
            'W_ReceiveDate'     => $this->faker->dateTimeBetween('-30 days', 'now'),
            'created_at'        => $now,
            'updated_at'        => $now,
        ];
    }
}