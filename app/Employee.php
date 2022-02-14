<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function bankInfos()
    {
        return $this->hasMany(EmployeeBankInfo::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function leaveApplications()
    {
        return $this->hasMany(leaveApplications::class);
    }
    public function attendanceData()
    {
        return $this->hasMany(AttendanceData::class);
    }
    public function allowances()
    {
        return $this->hasMany(SalaryAllowance::class);
    }

    public function deductions()
    {
        return $this->hasMany(SalaryDeduction::class);
    }

    public function salaryIncrements()
    {
        return $this->hasMany(SalaryIncrement::class);
    }
    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function getTotalAllowances()
    {
        return $this->allowances()->sum('amount');
    }

    public function getTotalDeductions()
    {
        return $this->deductions()->sum('amount');
    }

    public function getGrossSalary()
    {
        return $this->basic_salary + $this->getTotalAllowances();
    }

    public function getNetSalary()
    {
        return $this->getGrossSalary() - $this->getTotalDeductions();
    }
}
