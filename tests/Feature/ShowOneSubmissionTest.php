<?php

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('not able to get submission\'s details if it is not logged in', function () {
    $user = User::newFactory()->patient()->patientInformation()->create();
    $submission = Submission::newFactory()->create(['patient_id' => $user->id]);
    $response = $this->getJson(route('submissions.show', "$submission->id"));
    $response->assertUnauthorized();
});

test('not able to get other patient\'s submission\'s details', function () {
    $user = User::newFactory()->patient()->patientInformation()->create();
    $this->actingAs($user);

    $submissionPatient = User::newFactory()->patient()->patientInformation()->create();
    $submission = Submission::newFactory()->create(['patient_id' => $submissionPatient->id]);

    $response = $this->getJson(route('submissions.show', "$submission->id"));
    $response->assertForbidden();
});

test('view submission\'s details successfully as a patient', function () {
    $user = User::newFactory()->patient()->patientInformation()->create();
    $this->actingAs($user);

    $submission = Submission::newFactory()->create(['patient_id' => $user->id]);

    $response = $this->getJson(route('submissions.show', "$submission->id"));
    $response->assertSuccessful();
});

test('view submission\'s details successfully as a doctor', function () {
    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $submission = Submission::newFactory()->create();

    $response = $this->getJson(route('submissions.show', "$submission->id"));
    $response->assertSuccessful();
});
