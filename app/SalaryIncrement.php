<?php

namespace App;

use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Model;

class SalaryIncrement extends Model
{
    use ModelScopes;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
