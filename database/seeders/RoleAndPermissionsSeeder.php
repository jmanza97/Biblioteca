<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $librarian = Role::firstOrCreate(['name' => 'Librarian']);
        $student = Role::firstOrCreate(['name' => 'Student']);
        $teacher = Role::firstOrCreate(['name' => 'Teacher']);

        $permissions = [
            'books' => ['create book', 'view book', 'update book', 'delete book'],
            'authors' => ['create author', 'view author', 'update author', 'delete author'],
            'categories' => ['create category', 'view category', 'update category', 'delete category'],
            'loans' => ['create loan', 'view loan', 'update loan', 'delete loan'],
            'users' => ['create user', 'view user', 'update user', 'delete user'],
        ];

        foreach ($permissions as $group => $perms) {
            foreach ($perms as $perm) {
                $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
                $librarian->givePermissionTo($permission);
                $admin->givePermissionTo($permission);
            }
        }

        // admin gets all permissions
        $admin->givePermissionTo(Permission::pluck('id')->toArray());

        // librarian gets all permissions except user management
        $librarian->syncPermissions(Permission::whereNotIn('name', ['create user', 'view user', 'update user', 'delete user'])->pluck('id')->toArray());

        // teacher and student get only view permissions
        $teacher->syncPermissions(['view book', 'view loan', 'create loan']);
        $student->syncPermissions(['view book', 'view loan', 'create loan']);
    }
}
