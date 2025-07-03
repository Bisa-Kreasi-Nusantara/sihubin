<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Data role
        $roles = [
            "administrator",
            "teacher",
            "student"
        ];

        // Data permission
        $permissions = [
            "dashboard.view",

            "company_refrences.view",

            "internship_request.view",
            "internship_request.create",
            "internship_request.edit",
            "internship_request.delete",
            "internship_request.import",
            "internship_request.export",

            "internship_schedules.view",
            "internship_schedules.edit",
            "internship_schedules.export",

            "users_management.view",
            "users_management.create",
            "users_management.edit",
            "users_management.delete",

            "companies_management.view",
            "companies_management.create",
            "companies_management.edit",
            "companies_management.delete",

            "student_management.view",
            "student_management.create",
            "student_management.edit",
            "student_management.delete",
            "student_management.import",

            "criteria_weight_management.view",
            "criteria_weight_management.create",
            "criteria_weight_management.edit",
            "criteria_weight_management.delete",

            "majors_management.view",
            "majors_management.create",
            "majors_management.edit",
            "majors_management.delete",

            "role_permission.view",
            "role_permission.create",
            "role_permission.edit",
            "role_permission.delete",
        ];

        // Simpan roles
        $roleIds = [];
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $roleIds[$roleName] = $role->id;
        }

        // Simpan permissions
        $permissionIds = [];
        foreach (array_unique($permissions) as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $permissionIds[$permissionName] = $permission->id;
        }

        // Role-permission mapping (contoh)
        $rolePermissions = [
            'administrator' => [
                "dashboard.view",
                "company_refrences.view",
                "internship_request.view",
                "internship_request.create",
                "internship_request.edit",
                "internship_request.delete",
                "internship_request.import",
                "internship_request.export",
                "internship_schedules.view",
                "internship_schedules.edit",
                "internship_schedules.export",
                "users_management.view",
                "users_management.create",
                "users_management.edit",
                "users_management.delete",
                "companies_management.view",
                "companies_management.create",
                "companies_management.edit",
                "companies_management.delete",
                "student_management.view",
                "student_management.create",
                "student_management.edit",
                "student_management.delete",
                "student_management.import",
                "criteria_weight_management.view",
                "criteria_weight_management.create",
                "criteria_weight_management.edit",
                "criteria_weight_management.delete",
                "majors_management.view",
                "majors_management.create",
                "majors_management.edit",
                "majors_management.delete",
                "role_permission.view",
                "role_permission.create",
                "role_permission.edit",
                "role_permission.delete",
            ],
            'teacher'       => [
                "dashboard.view",
                "company_refrences.view",
                "internship_request.view",
                "internship_schedules.view",
                "student_management.view",
                "student_management.edit",
            ],
            'student'       => [
                "dashboard.view",
                "company_refrences.view",
                "internship_request.view",
                "internship_request.create",
                "internship_request.edit",
                "internship_schedules.view",
            ],
        ];

        // Simpan role_permission
        foreach ($rolePermissions as $role => $perms) {
            foreach ($perms as $perm) {
                RolePermission::firstOrCreate([
                    'roles_id'       => $roleIds[$role],
                    'permissions_id' => $permissionIds[$perm],
                ]);
            }
        }
    }
}
