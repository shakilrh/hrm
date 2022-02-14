<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'dashboard']);
        // create notifications permissions
        Permission::create(['name' => 'notifications.index']);
        Permission::create(['name' => 'notifications.mark-as-read']);
        Permission::create(['name' => 'notifications.destroy']);
        // create branches permissions
        Permission::create(['name' => 'branches.index']);
        Permission::create(['name' => 'branches.create']);
        Permission::create(['name' => 'branches.store']);
        Permission::create(['name' => 'branches.edit']);
        Permission::create(['name' => 'branches.update']);
        Permission::create(['name' => 'branches.destroy']);
        // create departments permissions
        Permission::create(['name' => 'departments.index']);
        Permission::create(['name' => 'departments.create']);
        Permission::create(['name' => 'departments.store']);
        Permission::create(['name' => 'departments.edit']);
        Permission::create(['name' => 'departments.update']);
        Permission::create(['name' => 'departments.destroy']);
        Permission::create(['name'=> 'departments.get-designation']);
        // create designations permissions
        Permission::create(['name' => 'designations.index']);
        Permission::create(['name' => 'designations.create']);
        Permission::create(['name' => 'designations.store']);
        Permission::create(['name' => 'designations.edit']);
        Permission::create(['name' => 'designations.update']);
        Permission::create(['name' => 'designations.destroy']);
        // create employees permissions
        Permission::create(['name' => 'employees.index']);
        Permission::create(['name' => 'employees.create']);
        Permission::create(['name' => 'employees.store']);
        Permission::create(['name' => 'employees.show']);
        Permission::create(['name' => 'employees.edit']);
        Permission::create(['name' => 'employees.update']);
        Permission::create(['name' => 'employees.destroy']);
        // create employees document permissions
        Permission::create(['name' => 'employees.document.store']);
        Permission::create(['name' => 'employees.document.destroy']);
        // create employees bank permissions
        Permission::create(['name' => 'employees.bank.store']);
        Permission::create(['name' => 'employees.bank.update']);
        Permission::create(['name' => 'employees.bank.destroy']);
        // create payroll permissions
        Permission::create(['name' => 'payroll.salary.manager.index']);
        Permission::create(['name' => 'payroll.salary.manager.manage']);
        Permission::create(['name' => 'payroll.salary.manager.allowance.store']);
        Permission::create(['name'=> 'payroll.salary.manager.allowance.destroy']);
        Permission::create(['name' => 'payroll.salary.manager.deduction.store']);
        Permission::create(['name'=> 'payroll.salary.manager.deduction.destroy']);
        Permission::create(['name' => 'payroll.salary.manager.increment.store']);
        Permission::create(['name'=>'payroll.salary.manager.increment.destroy']);
        // create payroll salary increment history permissions
        Permission::create(['name' =>'payroll.salary.increment.index']);
        // create payroll payslips permissions
        Permission::create(['name' => 'payroll.payslips.index']);
        Permission::create(['name' => 'payroll.payslips.create']);
        Permission::create(['name' => 'payroll.payslips.store']);
        Permission::create(['name' => 'payroll.payslips.show']);
        Permission::create(['name' => 'payroll.payslips.edit']);
        Permission::create(['name' => 'payroll.payslips.update']);
        Permission::create(['name' => 'payroll.payslips.destroy']);
        Permission::create(['name' => 'payroll.payslips.print']);
        // create expenses permissions
        Permission::create(['name' => 'expenses.index']);
        Permission::create(['name' => 'expenses.create']);
        Permission::create(['name' => 'expenses.store']);
        Permission::create(['name' => 'expenses.edit']);
        Permission::create(['name' => 'expenses.update']);
        Permission::create(['name' => 'expenses.destroy']);
        // create leave permissions
        Permission::create(['name' => 'leave.types.index']);
        Permission::create(['name' => 'leave.types.store']);
        Permission::create(['name' => 'leave.types.update']);
        Permission::create(['name' => 'leave.types.destroy']);
        // create leave applications permissions
        Permission::create(['name' => 'leave.applications.index']);
        Permission::create(['name' => 'leave.applications.create']);
        Permission::create(['name' => 'leave.applications.store']);
        Permission::create(['name' => 'leave.applications.edit']);
        Permission::create(['name' => 'leave.applications.update']);
        Permission::create(['name' => 'leave.applications.destroy']);
        // create attendances permissions
        Permission::create(['name' => 'attendances.index']);
        Permission::create(['name' => 'attendances.create']);
        Permission::create(['name' => 'attendances.store']);
        Permission::create(['name' => 'attendances.edit']);
        Permission::create(['name' => 'attendances.update']);
        Permission::create(['name' => 'attendances.destroy']);
        Permission::create(['name' => 'attendances.report']);
        Permission::create(['name' => 'attendances.print']);
        // create award types permissions
        Permission::create(['name' => 'award.types.index']);
        Permission::create(['name' => 'award.types.store']);
        Permission::create(['name' => 'award.types.update']);
        Permission::create(['name' => 'award.types.destroy']);
        // create award permissions
        Permission::create(['name' => 'awards.index']);
        Permission::create(['name' => 'awards.create']);
        Permission::create(['name' => 'awards.store']);
        Permission::create(['name' => 'awards.edit']);
        Permission::create(['name' => 'awards.update']);
        Permission::create(['name' => 'awards.destroy']);
        // create events permissions
        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.store']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.update']);
        Permission::create(['name' => 'events.destroy']);
        Permission::create(['name' => 'events.calendar']);
        // create noticeboard permissions
        Permission::create(['name' => 'noticeboard.index']);
        Permission::create(['name' => 'noticeboard.create']);
        Permission::create(['name' => 'noticeboard.store']);
        Permission::create(['name' => 'noticeboard.show']);
        Permission::create(['name' => 'noticeboard.edit']);
        Permission::create(['name' => 'noticeboard.update']);
        Permission::create(['name' => 'noticeboard.destroy']);

        // Only for devloper
        /* Permission::create(['name' => 'permissions.index']);
        Permission::create(['name' => 'permissions.create']);
        Permission::create(['name' => 'permissions.store']);
        Permission::create(['name' => 'permissions.show']);
        Permission::create(['name' => 'permissions.edit']);
        Permission::create(['name' => 'permissions.update']);
        Permission::create(['name' => 'permissions.destroy']); */

        // Create permission role
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.store']);
        Permission::create(['name' => 'roles.show']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.update']);
        Permission::create(['name' => 'roles.destroy']);
        // create permissions for users
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.store']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.destroy']);
        // create profile permissions
        Permission::create(['name' => 'users.profile']);
        Permission::create(['name' => 'users.profile.update']);
        // create password permissions
        Permission::create(['name' => 'users.password.change']);
        Permission::create(['name' => 'users.password.update']);
        // create settings permissions
        Permission::create(['name' => 'settings.index']);
        Permission::create(['name' => 'settings.update']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'employee']);
        $role->givePermissionTo([
            'dashboard',

            'expenses.index','expenses.create','expenses.store','expenses.edit','expenses.update','expenses.destroy',

            'leave.applications.index','leave.applications.create','leave.applications.store','leave.applications.edit','leave.applications.update','leave.applications.destroy',

            'noticeboard.index','noticeboard.show',

            'awards.index',

            'attendances.index','attendances.report','attendances.print',

            'events.calendar',

            'payroll.salary.manager.manage','payroll.payslips.index','payroll.payslips.show',

            'notifications.index','notifications.mark-as-read','notifications.destroy',

            'users.profile','users.profile.update','users.password.change','users.password.update',
        ]);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['dashboard']);
    }
}
