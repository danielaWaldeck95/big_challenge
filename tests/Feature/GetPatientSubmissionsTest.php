<?php

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
const totalSubmissionsNumber = 6;
it('cannot get submissions if it is not logged in', function () {
    $response = $this->getJson(route('patient.submissions.index'), []);
    $response->assertUnauthorized();
});

test('get my submissions successfully as a patient', function () {
    $user = User::newFactory()->patient()->withInformation()->create();
    $this->actingAs($user);

    Submission::newFactory()
    ->count(totalSubmissionsNumber)
    ->state(new Sequence(
        ['patient_id' => $user->id],
        ['patient_id' => User::newFactory()->patient()->withInformation()->create()],
    ))
    ->create();

    $response = $this->getJson(route('patient.submissions.index'));
    $response->assertSuccessful();
    $this->assertEquals(count($response['submissions']), totalSubmissionsNumber/2);
});
