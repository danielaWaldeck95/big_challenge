<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('not able to accept submission if not logged user', function () {
    $patient = User::newFactory()->patient()->patientInformation()->create();
    $submission = Submission::newFactory()->create(['patient_id' => $patient->id]);

    $response = $this->putJson(route('submissions.accept', $submission->id), []);
    $response->assertUnauthorized();
});

test('not able to accept submission if it is not a doctor', function () {
    $patient = User::newFactory()->patient()->patientInformation()->create();
    $submission = Submission::newFactory()->create(['patient_id' => $patient->id]);

    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $response = $this->putJson(route('submissions.accept', $submission->id), []);
    $response->assertForbidden();
});

test('not able to accept submission that has already been assigned', function () {
    $patient = User::newFactory()->patient()->patientInformation()->create();
    $doctor = User::newFactory()->doctor()->create();

    $submission = Submission::newFactory()->create(['patient_id' => $patient->id, 'doctor_id' => $doctor->id]);

    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->putJson(route('submissions.accept', $submission->id), []);
    $response->assertForbidden();
});

test('accept submission successfully as a doctor', function () {
    $patient = User::newFactory()->patient()->patientInformation()->create();
    $submission = Submission::newFactory()->create(['patient_id' => $patient->id]);

    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->putJson(route('submissions.accept', $submission->id), []);
    $response->assertSuccessful();

    $updatedSubmission = Submission::findOrFail($submission->id);
    $this->assertEquals(SubmissionStatuses::InProgress, $updatedSubmission->status);
});
