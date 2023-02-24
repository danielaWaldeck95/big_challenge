<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\SubmissionStatuses;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->name(),
            'symptoms' => fake()->text(),
            'patient_id' => User::newFactory()->patient()->patientInformation()->create(),
            'status' => SubmissionStatuses::Pending
        ];
    }
}
