<?php

namespace Database\Seeders;

use App\Enums\UserTypes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'update personal information',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission]
            );
        }
        $patientRole = Role::findByName(UserTypes::PATIENT->value);
        $patientRole->givePermissionTo('update personal information');

    }
}
