<?php

use App\Award;
use App\Event;
use App\Branch;
use App\Notice;
use App\Expense;
use App\Payslip;
use App\Employee;
use App\AwardType;
use App\LeaveType;
use App\Attendance;
use App\Department;
use App\Designation;
use App\AttendanceData;
use App\SalaryAllowance;
use App\SalaryDeduction;
use App\SalaryIncrement;
use App\EmployeeBankInfo;
use App\EmployeeDocument;
use App\LeaveApplication;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);

        /* if (env('APP_DEBUG') === true) {
            factory(Branch::class, 5)->create();
            factory(Department::class, 20)->create();
            factory(Designation::class, 50)->create();
            factory(Employee::class, 5)->create();
            factory(EmployeeDocument::class, 20)->create();
            factory(EmployeeBankInfo::class, 20)->create();

            factory(LeaveType::class, 5)->create();
            factory(LeaveApplication::class, 12)->create();

            factory(Attendance::class, 5)->create();
            factory(AttendanceData::class, 12)->create();

            factory(AwardType::class, 5)->create();
            factory(Award::class, 10)->create();

            factory(Payslip::class, 5)->create();
            factory(SalaryAllowance::class, 5)->create();
            factory(SalaryDeduction::class, 5)->create();
            factory(SalaryIncrement::class, 5)->create();

            factory(Expense::class, 5)->create();
            factory(Event::class, 5)->create();
            factory(Notice::class, 5)->create();
        } */
    }
}
