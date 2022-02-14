<?php

namespace App;

use App\Employee;
use App\AwardType;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function awardType()
    {
        return $this->belongsTo(AwardType::class, 'award_type_id', 'id');
    }
}
