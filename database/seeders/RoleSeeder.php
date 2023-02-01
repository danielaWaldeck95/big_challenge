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
        $doctorRole = Role::create(['name' => UserTypes::DOCTOR]);
        $patientRole = Role::create(['name' => UserTypes::PATIENT]);
    }
}
