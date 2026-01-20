<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_super_admin = Role::where('name', 'super_admin')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $role_employee = Role::where('name', 'employee')->first();
        $role_pimpinan = Role::where('name', 'pimpinan')->first();
        // dd($role_admin->id);
        User::firstOrCreate([
            "username" => "ryugen",
        ], [
            "name" => "ryugen",
            "role_id" =>  $role_employee->id,
            "password" => bcrypt('12345678')
        ]);
        User::firstOrCreate([
            "username" => "admin",
        ], [
            "name" => "admin",
            "role_id" => $role_admin->id,
            "password" => bcrypt('12345678')
        ]);
        User::firstOrCreate([
            "username" => "super_admin",
        ], [
            "name" => "super admin",
            "role_id" => $role_super_admin->id,
            "password" => bcrypt('12345678')
        ]);
        User::firstOrCreate([
            "username" => "pimpinan",
        ], [
            "name" => "pimpinan",
            "role_id" => $role_pimpinan->id,
            "password" => bcrypt('12345678')
        ]);
    }
}
