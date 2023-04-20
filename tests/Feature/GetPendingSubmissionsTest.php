<?php

use App\Enums\SubmissionStatuses;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->patient = User::newFactory()->patient()->patientInformation()->create();
    $this->doctor = User::newFactory()->doctor()->create();

    Submission::newFactory()
        ->count(3)->sequence(
            ['status' => SubmissionStatuses::InProgress],
            ['status' => SubmissionStatuses::Done],
            ['status' => SubmissionStatuses::Pending]
        )->create();
});

it('throws an error when trying to get submissions as invalid user', function ($userType, $expectedResponse) {
    if ($userType) {
        $this->actingAs($this->patient);
    }

    $response = $this->getJson(route('submissions.pending.index'));
    $response->assertStatus($expectedResponse);
})->with('invalid-users');

it('get all pending submissions successfully as a doctor', function () {
    $response = $this->actingAs($this->doctor)->getJson(route('submissions.pending.index'));
    $response->assertSuccessful()->assertJsonCount(
        Submission::where('status', SubmissionStatuses::Pending)->count(),
        'data'
    );
});
