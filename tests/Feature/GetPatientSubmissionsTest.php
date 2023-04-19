<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
const totalSubmissionsNumber = 3;

beforeEach(function () {
    $this->patient = User::newFactory()->patient()->patientInformation()->create();
    $this->doctor = User::newFactory()->doctor()->create();
    $this->pendingSubmission = Submission::newFactory()->create(['patient_id' => $this->patient->id]);
    $this->inProgressSubmission = Submission::newFactory()
    ->count(totalSubmissionsNumber)->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'status' => SubmissionStatuses::InProgress
    ]);
    $this->otherPatientSubmission = Submission::newFactory()->create();
});

it('throws an error when trying to get submissions as a guest', function () {
    $response = $this->getJson(route('submissions.index'));
    $response->assertUnauthorized();
});

test('get my submissions successfully as a patient', function () {
    $response = $this->actingAs($this->patient)->getJson(route('submissions.index'));
    $response->assertSuccessful()->assertJsonCount(4, 'data');
});

it('filters patient submissions by status', function () {
    $response = $this->actingAs($this->patient)->getJson(route('submissions.index', ['status' => 'pending']));
    $response->assertSuccessful()->assertJsonCount(1, 'data');

    $response = $this->actingAs($this->patient)->getJson(route('submissions.index', ['status' => 'in progress']));
    $response->assertSuccessful()->assertJsonCount(3, 'data');
});
