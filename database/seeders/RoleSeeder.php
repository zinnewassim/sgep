<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'display_name' => 'Administrateur',
            'description' => 'Gestion totale du système',
        ]);

        $employe = Role::firstOrCreate([
            'name' => 'employe',
            'display_name' => 'Employé',
            'description' => 'Accès limité à ses propres informations',
        ]);

        // Define permissions (basic ones)
        $perms = [
            'view-dashboard',
            'manage-employees',
            'manage-presence',
            'view-own-presence',
            'manage-hr',
            'manage-sanctions',
            'manage-planning',
            'manage-system',
        ];

        $permissionIds = [];
        foreach ($perms as $p) {
            $permissionIds[] = Permission::firstOrCreate(['name' => $p, 'display_name' => $p])->id;
        }

        // Attach all permissions to Admin
        $admin->syncPermissions($permissionIds);

        // Attach limited permissions to Employe
        $employe->syncPermissions([
            Permission::where('name', 'view-dashboard')->first()->id,
            Permission::where('name', 'view-own-presence')->first()->id,
        ]);
    }
}
