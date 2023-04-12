<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

dataset('invalid-users', [
    ['patient', Response::HTTP_FORBIDDEN],
    [null, Response::HTTP_UNAUTHORIZED],
]);

beforeEach(function () {
    $this->patient = User::newFactory()->patient()->patientInformation()->create();
    $this->doctor = User::newFactory()->doctor()->create();
    $this->pendingSubmission = Submission::newFactory()->create(['patient_id' => $this->patient->id]);
    $this->inProgressSubmission = Submission::newFactory()->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id
    ]);
});

test('it throws an exception when invalid user', function ($userType, $expectedResponse) {
    if ($userType) {
        $user = User::newFactory()->{$userType}()->create();
        $this->actingAs($user);
    }

    $response = $this->postJson(route('submissions.accept', $this->pendingSubmission->id));
    $response->assertStatus($expectedResponse);
})
->with('invalid-users');

test('it throws and exception when the submission already has a doctor assigned', function () {
    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->postJson(route('submissions.accept', $this->inProgressSubmission->id));
    $response->assertForbidden();
});

test('successfully accepted submission', function () {
    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->postJson(route('submissions.accept', $this->pendingSubmission->id));
    $response->assertSuccessful();

    $updatedSubmission = Submission::findOrFail($this->pendingSubmission->id);
    $this->assertEquals(SubmissionStatuses::InProgress, $updatedSubmission->status);
    $this->assertEquals($user->id, $updatedSubmission->doctor_id);
});
