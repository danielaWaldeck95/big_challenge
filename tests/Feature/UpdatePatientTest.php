<?php

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

const password = 'password';

beforeEach(function () {
    $doctorRole = Role::create(['name' => UserTypes::DOCTOR]);
    $patientRole = Role::create(['name' => UserTypes::PATIENT]);

    Permission::create(['name' => 'update personal information']);

    $patientRole->givePermissionTo('update personal information');

    $doctor = User::create([
        'name' => 'doctor',
        'email' => 'doctor@test.com',
        'password' => password
    ]);

    $doctor->assignRole(UserTypes::DOCTOR->value);

    $patient = User::create([
        'name' => 'patient',
        'email' => 'patient@test.com',
        'password' => password
    ]);

    $patient->assignRole(UserTypes::PATIENT->value);
});


it('does not update a patient if it is not logged in', function () {
    $response = $this->putJson('api/update', []);
    $response->assertStatus(Response::HTTP_UNAUTHORIZED);
});

it('does not update a user if it is not a patient', function () {


    $this->postJson('api/login', ['email' => 'doctor@test.com', 'password' => password]);

    $response = $this->putJson('api/update', []);
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

it('must include height value on update', function () {


    $this->postJson('api/login', ['email' => 'patient@test.com', 'password' => password]);

    $updatePatient = [
        'phone' => '123456789',
        'weight' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson('api/update', $updatePatient);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('must include weight value on update', function () {


    $this->postJson('api/login', ['email' => 'patient@test.com', 'password' => password]);

    $updatePatient = [
        'phone' => '123456789',
        'height' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson('api/update', $updatePatient);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('must include phone value on update', function () {


    $this->postJson('api/login', ['email' => 'patient@test.com', 'password' => password]);

    $updatePatient = [
        'weight' => 65,
        'height' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson('api/update', $updatePatient);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can update patient information without other information field', function () {
    $this->postJson('api/login', ['email' => 'patient@test.com', 'password' => password]);

    $updatePatient = [
        'phone' => '123456789',
        'height' => 65,
        'weight' => 179
    ];

    $response = $this->putJson('/api/update', $updatePatient);
    $response->assertStatus(Response::HTTP_OK);
    $this->assertDatabaseHas('users', $updatePatient);
});

it('can update patient information', function () {
    $this->postJson('api/login', ['email' => 'patient@test.com', 'password' => password]);

    $updatePatient = [
        'phone' => '123456789',
        'height' => 65,
        'weight' => 179,
        'other_information' => 'other information'
    ];

    $response = $this->putJson('/api/update', $updatePatient);
    $response->assertStatus(Response::HTTP_OK);
    $this->assertDatabaseHas('users', $updatePatient);
});
