<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->patient = User::newFactory()->patient()->patientInformation()->create();
    $this->doctor = User::newFactory()->doctor()->create();
    $this->pendingSubmission = Submission::newFactory()->create(['patient_id' => $this->patient->id]);
    $this->inProgressSubmission = Submission::newFactory()
    ->count(3)->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'status' => SubmissionStatuses::InProgress
    ]);
    $this->otherPatientSubmission = Submission::newFactory()->create();

    $this->doctorSubmissionsCount = Submission::where('doctor_id', $this->doctor->id)->count();
    $this->patientSubmissionsCount = Submission::where('patient_id', $this->patient->id)->count();
    $this->pendingSubmissionsForPatientCount = Submission::where('patient_id', $this->patient->id)
        ->where('status', SubmissionStatuses::Pending)
        ->count();
    $this->inProgressSubmissionsForPatientCount = Submission::where('patient_id', $this->patient->id)
        ->where('status', SubmissionStatuses::InProgress)
        ->count();
    $this->pendingSubmissionsForDoctorCount = Submission::where('doctor_id', $this->doctor->id)
        ->where('status', SubmissionStatuses::Pending)
        ->count();
    $this->inProgressSubmissionsForDoctorCount = Submission::where('doctor_id', $this->doctor->id)
        ->where('status', SubmissionStatuses::InProgress)
        ->count();
});

it('throws an error when trying to get submissions as a guest', function () {
    $response = $this->getJson(route('submissions.index'));
    $response->assertUnauthorized();
});

test('get my submissions successfully as a patient', function () {
    $response = $this->actingAs($this->patient)->getJson(route('submissions.index'));
    $response->assertSuccessful()->assertJsonCount($this->patientSubmissionsCount, 'data');
});

test('get my submissions successfully as a doctor', function () {
    $response = $this->actingAs($this->doctor)->getJson(route('submissions.index'));
    $response->assertSuccessful()->assertJsonCount($this->doctorSubmissionsCount, 'data');
});

it('filters patient submissions by status', function () {
    $response = $this->actingAs($this->patient)->getJson(route('submissions.index', ['status' => 'pending']));
    $response->assertSuccessful()->assertJsonCount($this->pendingSubmissionsForPatientCount, 'data');

    $response = $this->actingAs($this->patient)->getJson(route('submissions.index', ['status' => 'in progress']));
    $response->assertSuccessful()->assertJsonCount($this->inProgressSubmissionsForPatientCount, 'data');
});

it('filters doctor submissions by status', function () {
    $response = $this->actingAs($this->doctor)->getJson(route('submissions.index', ['status' => 'pending']));
    $response->assertSuccessful()->assertJsonCount($this->pendingSubmissionsForDoctorCount, 'data');

    $response = $this->actingAs($this->doctor)->getJson(route('submissions.index', ['status' => 'in progress']));
    $response->assertSuccessful()->assertJsonCount($this->inProgressSubmissionsForDoctorCount, 'data');
});
