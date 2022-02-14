<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceData extends Model
{
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
