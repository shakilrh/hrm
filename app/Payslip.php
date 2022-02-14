<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function getNetSalary()
    {
        return $this->employee->getNetSalary() - $this->instant_deduction;
    }
}
