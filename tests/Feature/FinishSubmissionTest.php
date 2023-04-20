<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->patient = User::newFactory()->patient()->patientInformation()->create();
    $this->doctor = User::newFactory()->doctor()->create();
    $this->pendingSubmission = Submission::newFactory()->create(['patient_id' => $this->patient->id]);
    $this->submission = Submission::newFactory()->includePrescription()->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id
    ]);

    $this->submissionWithoutPrescription = Submission::newFactory()->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id
    ]);
});

test('it throws an exception when invalid user', function ($userType, $expectedResponse) {
    if ($userType) {
        $user = User::newFactory()->{$userType}()->create();
        $this->actingAs($user);
    }

    $response = $this->postJson(route('submissions.finish', $this->submission->id));
    $response->assertStatus($expectedResponse);
})
->with('invalid-users');

test('it throws and exception when the submission has no prescription', function () {
    $response = $this->actingAs($this->doctor)->postJson(route('submissions.finish', $this->submissionWithoutPrescription->id));
    $response->assertForbidden();
});

test('successfully finished submission', function () {
    $response = $this->actingAs($this->doctor)->postJson(route('submissions.finish', $this->submission->id));
    $response->assertSuccessful();
});
