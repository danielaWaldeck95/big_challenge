<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use Illuminate\Http\UploadedFile;
use Storage;

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

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function includePrescription(): static
    {
        return $this->afterCreating(function (Submission $submission) {
            Storage::fake();
            $prescriptionFile = UploadedFile::fake()->create('prescription.txt', 1000, 'application/txt');

            $submission->prescription()->create([
                'name' => $prescriptionFile->getClientOriginalName(),
                'path' => $prescriptionFile->store('prescriptions', 'public'),
                'mime_type' => $prescriptionFile->getMimeType(),
                'size' => $prescriptionFile->getSize(),
            ]);

            $submission->save();
        });
    }
}
