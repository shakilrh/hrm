<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function data()
    {
        return $this->hasMany(AttendanceData::class);
    }
}
