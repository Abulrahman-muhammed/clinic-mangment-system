<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'view_dashboard',

            // Clinic Management
            'view_doctors', 'create_doctors', 'edit_doctors', 'delete_doctors', 'export_doctors', 'import_doctors',
            'view_departments', 'create_departments', 'edit_departments', 'delete_departments',
            'view_doctor_schedules', 'create_doctor_schedules', 'edit_doctor_schedules', 'delete_doctor_schedules',

            // Patients & Services
            'view_patients', 'create_patients', 'edit_patients', 'delete_patients', 'export_patients', 'import_patients',
            'view_appointments', 'create_appointments', 'edit_appointments', 'delete_appointments', 'cancel_appointments', 'approve_appointments',
            'view_services', 'create_services', 'edit_services', 'delete_services',

            // Finance
            'view_invoices', 'create_invoices', 'edit_invoices', 'delete_invoices', 'print_invoices', 'export_invoices',

            // Staff
            'view_receptionists', 'create_receptionists', 'edit_receptionists', 'delete_receptionists',

            // Reports
            'view_reports', 'generate_reports', 'export_reports',

            // Administration
            'view_users', 'create_users', 'edit_users', 'delete_users', 'ban_users',
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_roles',
            'view_permissions', 'create_permissions', 'edit_permissions', 'delete_permissions', 'assign_permissions',

            // Contact & Settings
            'view_contacts', 'create_contacts', 'edit_contacts', 'delete_contacts', 'reply_contacts',
            'view_settings', 'update_settings', 'manage_backup', 'manage_logs',

            // Notifications
            'view_notifications', 'send_notifications',
            // Schedules permissions
            'view_schedules', 'create_schedules', 'edit_schedules', 'delete_schedules',
            // settings permissions
            'view_settings', 'update_settings', 'manage_backup', 'manage_logs',
            // roles permissions
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_roles',
            // permissions permissions
            'view_permissions', 'create_permissions', 'edit_permissions', 'delete_permissions', 'assign_permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        // 🧠 إنشاء الأدوار
        $adminRole = Role::updateOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $doctorRole = Role::updateOrCreate(['name' => 'doctor'], ['guard_name' => 'web']);
        $receptionistRole = Role::updateOrCreate(['name' => 'receptionist'], ['guard_name' => 'web']);

        // 🧩 صلاحيات الـ Admin (كل الصلاحيات)
        $adminRole->syncPermissions(Permission::all());

        // 🩺 صلاحيات الـ Doctor
        $doctorPermissions = [
            'view_dashboard',
            'view_patients',
            'view_appointments',
            'edit_appointments',
            'approve_appointments',
            'cancel_appointments',
            'view_services',
            'view_invoices',
            'view_notifications',
            'view_schedules',
            'edit_schedules',
        ];
        $doctorRole->syncPermissions($doctorPermissions);

        // 🧾 صلاحيات الـ Receptionist
        $receptionistPermissions = [
            'view_dashboard',

            'view_patients',
            'create_patients',
            'edit_patients',

            'view_appointments',
            'create_appointments',
            'edit_appointments',
            'cancel_appointments',

            'view_invoices',
            'create_invoices',
            'print_invoices',

            'view_doctors',
            'view_departments',

            'view_notifications',
            'view_schedules',
            'edit_schedules',
        ];
        $receptionistRole->syncPermissions($receptionistPermissions);
    }
}
