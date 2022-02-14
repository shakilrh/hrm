<?php

use App\User;
use Carbon\Carbon;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin user
        $admin = User::create([
            'name' => 'Md.Admin',
            'username' => 'admin',
            'email' => 'admin@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Md.User',
            'username' => 'user',
            'email' => 'user@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $user->assignRole('user');

        //employees
        /* $employee = User::create([
            'name' => 'Md.employee',
            'username' => 'employee',
            'email' => 'employee@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $employee->assignRole('employee');

        $employee = User::create([
            'name' => 'Md.employee1',
            'username' => 'employee1',
            'email' => 'employee1@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $employee->assignRole('employee');

        $employee = User::create([
            'name' => 'Md.employee2',
            'username' => 'employee2',
            'email' => 'employee2@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $employee->assignRole('employee');

        $employee = User::create([
            'name' => 'Md.employee3',
            'username' => 'employee3',
            'email' => 'employee3@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $employee->assignRole('employee');

        $employee = User::create([
            'name' => 'Md.employee4',
            'username' => 'employee4',
            'email' => 'employee4@hrm.com',
            'password' => bcrypt('password'),
            'image' => 'default.png',
            'status' => UserStatus::Active,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $employee->assignRole('employee'); */
    }
}
