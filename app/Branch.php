<?php

namespace App;

use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use ModelScopes;

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
