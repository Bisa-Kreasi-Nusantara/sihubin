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
            "dashboard",
            "internship_request",
            "weighing_result",
            "internship_schedules",
            "users_management",
            "companies_management",
            "student_management",
            "criteria_weight_management",
            "majors_management",
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
            'administrator' => ["dashboard", "internship_request", "weighing_result", "internship_schedules", "users_management", "companies_management", "student_management", "criteria_weight_management", "majors_management"],
            'teacher'       => ["dashboard", "internship_request", "weighing_result", "internship_schedules",],
            'student'       => ["dashboard", "internship_request"],
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
