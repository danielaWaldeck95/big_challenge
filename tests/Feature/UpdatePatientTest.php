<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('does not update a patient if it is not logged in', function () {
    $response = $this->putJson(route('patient.update'), []);
    $response->assertUnauthorized();
});

it('does not update a user if it is not a patient', function () {
    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->putJson(route('patient.update'), []);
    $response->assertForbidden();
});

it('must include height value on update', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $updatePatient = [
        'phone' => '123456789',
        'weight' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson(route('patient.update'), $updatePatient);
    $response->assertUnprocessable();
});

it('must include weight value on update', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $updatePatient = [
        'phone' => '123456789',
        'height' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson(route('patient.update'), $updatePatient);
    $response->assertUnprocessable();
});

it('must include phone value on update', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $updatePatient = [
        'weight' => 65,
        'height' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson(route('patient.update'), $updatePatient);
    $response->assertUnprocessable();
});

it('can update patient information without other information field', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $updatePatient = [
        'phone' => '123456789',
        'height' => 65,
        'weight' => 179
    ];

    $response = $this->putJson('/api/update', $updatePatient);
    $response->assertSuccessful();
    $this->assertDatabaseHas('users', $updatePatient);
});

it('can update patient information', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $updatePatient = [
        'phone' => '123456789',
        'height' => 65,
        'weight' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson(route('patient.update'), $updatePatient);
    $response->assertSuccessful();
    $this->assertDatabaseHas('users', $updatePatient);
});
