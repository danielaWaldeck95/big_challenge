<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->patient = User::newFactory()->patient()->patientInformation()->create();
    $this->doctor = User::newFactory()->doctor()->create();
    $this->otherDoctor = User::newFactory()->doctor()->create();
    $this->pendingSubmission = Submission::newFactory()->create(['patient_id' => $this->patient->id]);
    $this->inProgressSubmission = Submission::newFactory()->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'status' => SubmissionStatuses::InProgress
    ]);
    $this->invalidFileExtension = [
        'prescription' => UploadedFile::fake()->create('prescription.pdf')
    ];
    $this->validPrescription = [
        'prescription' => UploadedFile::fake()->create('prescription.txt')
    ];
});

it('throws an exception if not in progress submission', function () {
    $response = $this->actingAs($this->doctor)->postJson(
        route('submissions.prescriptions.store', $this->pendingSubmission),
        $this->validPrescription
    );
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

it('throws an exception if logged doctor is not assigned to the submission', function () {
    $response = $this->actingAs($this->otherDoctor)->postJson(
        route('submissions.prescriptions.store', $this->inProgressSubmission),
        $this->validPrescription
    );
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('patient cant upload prescription', function () {
    $response = $this->actingAs($this->patient)->postJson(
        route('submissions.prescriptions.store', $this->inProgressSubmission),
        $this->validPrescription
    );
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

it('throws an exception if file extension is not .txt', function () {
    $response = $this->actingAs($this->doctor)->postJson(
        route('submissions.prescriptions.store', $this->inProgressSubmission),
        $this->invalidFileExtension
    );
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('uploads prescription successfully', function () {
    Storage::fake();

    $response = $this->actingAs($this->doctor)->postJson(
        route('submissions.prescriptions.store', $this->inProgressSubmission),
        $this->validPrescription
    );

    $response->assertSuccessful();

    Storage::assertExists(
        config('filesystems.disks.do_spaces.folder') . '/' . $this->inProgressSubmission->id . '.txt'
    );
});
