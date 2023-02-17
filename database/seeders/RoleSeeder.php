<?php

namespace Database\Seeders;

use App\Enums\UserTypes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::findOrCreate(UserTypes::DOCTOR->value);
        Role::findOrCreate(UserTypes::PATIENT->value);
    }
}
