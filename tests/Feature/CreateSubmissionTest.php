<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('does not create a submission if it is not logged in', function () {
    $response = $this->postJson(route('submissions.store'), []);
    $response->assertUnauthorized();
});

it('does not create a submission if logged user is not patient', function () {
    $user = User::newFactory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->postJson(route('submissions.store'), []);
    $response->assertForbidden();
});

it('must include title value', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $data = [
        'symptoms' => 'my symptoms'
    ];

    $response = $this->postJson(route('submissions.store'), $data);
    $response->assertUnprocessable();
});

it('must include symptoms value', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $data = [
        'title' => 'my title'
    ];

    $response = $this->postJson(route('submissions.store'), $data);
    $response->assertUnprocessable();
});

it('can create a submission', function () {
    $user = User::newFactory()->patient()->create();
    $this->actingAs($user);

    $data = [
        'title' => 'title',
        'symptoms' => 'other symptoms'
    ];

    $response = $this->postJson(route('submissions.store'), $data);
    $response->assertSuccessful();
    $this->assertDatabaseHas('submissions', $data);
});
