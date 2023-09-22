<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->create();
        Student::factory(300)->create();
        // create permissions
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);
        Permission::create(['name' => 'add students']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'viewer']);
        $role1->givePermissionTo('view students');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('view students');
        $role2->givePermissionTo('edit students');
        $role2->givePermissionTo('add students');

        $role3 = Role::create(['name' => 'Super-Admin']);
        $role3->givePermissionTo('view students');
        $role3->givePermissionTo('edit students');
        $role3->givePermissionTo('delete students');
        $role3->givePermissionTo('add students');

        // create demo users
        User::create([
            'name' => 'viewer',
            'email' => 'viewer@example.com',
            'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        ])->assignRole($role1);

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        ])->assignRole($role2);

        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        ])->assignRole($role3);
    }
}
