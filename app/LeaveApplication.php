<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }
}
