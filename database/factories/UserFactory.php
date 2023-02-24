<?php

namespace Database\Factories;

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' =>  Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function patientInformation()
    {
        return $this->afterCreating(function (User $user) {
            $patientInformation = [
                'phone' => '123456789',
                'height' => 65,
                'weight' => 179,
                'other_information' => 'other information'
            ];
            $user->update($patientInformation);
        });
    }

    public function patient()
    {
        return $this->afterCreating(function (User $user) {
            $patientRole = Role::findOrCreate(UserTypes::PATIENT->value);

            Permission::findOrCreate('update personal information');
            $patientRole->givePermissionTo('update personal information');

            Permission::findOrCreate('create submissions');
            $patientRole->givePermissionTo('create submissions');

            $user->assignRole(UserTypes::PATIENT->value);
        });
    }

    public function doctor()
    {
        return $this->afterCreating(function (User $user) {
                Role::findOrCreate(UserTypes::DOCTOR->value);
                $user->assignRole(UserTypes::DOCTOR->value);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
