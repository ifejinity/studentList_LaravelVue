<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    // login
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remembered = $request->remember != false;
        if(Auth::attempt($validated, $remembered)) {
            $request->session()->regenerate();
            return redirect('/home');
        } else {
            return redirect()->back()->withErrors(['message' => 'Authentication failed. Please check your credentials.']);
        }
    }
    // logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function createRole(){
        // create permissions
        // Permission::create(['name' => 'view students']);
        // Permission::create(['name' => 'edit students']);
        // Permission::create(['name' => 'delete students']);
        // Permission::create(['name' => 'add students']);

        // create roles and assign existing permissions
        // $role1 = Role::create(['name' => 'viewer']);
        // $role1->givePermissionTo('view students');

        // $role2 = Role::create(['name' => 'admin']);
        // $role2->givePermissionTo('view students');
        // $role2->givePermissionTo('edit students');
        // $role2->givePermissionTo('add students');

        // $role3 = Role::create(['name' => 'Super-Admin']);
        // $role3->givePermissionTo('view students');
        // $role3->givePermissionTo('edit students');
        // $role3->givePermissionTo('delete students');
        // $role3->givePermissionTo('add students');

        // create demo users
        // User::create([
        //     'name' => 'viewer',
        //     'email' => 'viewer@example.com',
        //     'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        // ])->assignRole($role1);

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        //     'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        // ])->assignRole($role2);

        // User::create([
        //     'name' => 'superadmin',
        //     'email' => 'superadmin@example.com',
        //     'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        // ])->assignRole($role3);
    }
}
