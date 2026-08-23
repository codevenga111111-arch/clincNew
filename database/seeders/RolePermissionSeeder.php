<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'patients.view',
            'patients.create',
            'patients.update',
            'patients.delete',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'appointments.cancel',
            'pregnancy.view',
            'pregnancy.create',
            'pregnancy.update',
            'prescriptions.view',
            'prescriptions.create',
            'prescriptions.update',
            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.mark-paid',
            'reports.view',
            'reports.export',
            'settings.view',
            'settings.update',
            'assistants.view',
            'assistants.create',
            'assistants.update',
            'assistants.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        $doctor = Role::create(['name' => 'doctor', 'guard_name' => 'web']);
        $doctor->givePermissionTo([
            'patients.view',
            'patients.create',
            'patients.update',
            'patients.delete',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'appointments.cancel',
            'pregnancy.view',
            'pregnancy.create',
            'pregnancy.update',
            'prescriptions.view',
            'prescriptions.create',
            'prescriptions.update',
            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.mark-paid',
            'reports.view',
            'reports.export',
            'settings.view',
            'settings.update',
            'assistants.view',
            'assistants.create',
            'assistants.update',
            'assistants.delete',
        ]);

        $assistant = Role::create(['name' => 'assistant', 'guard_name' => 'web']);
        $assistant->givePermissionTo([
            'patients.view',
            'patients.create',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'pregnancy.view',
            'invoices.view',
            'invoices.create',
        ]);

        $patient = Role::create(['name' => 'patient', 'guard_name' => 'web']);
        $patient->givePermissionTo([
            'appointments.view',
            'appointments.create',
            'appointments.cancel',
            'pregnancy.view',
            'prescriptions.view',
            'invoices.view',
            'invoices.mark-paid',
            'settings.view',
            'settings.update',
        ]);
    }
}
