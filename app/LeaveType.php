<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    public function applications()
    {
        return $this->hasMany(LeaveApplication::class);
    }
}
