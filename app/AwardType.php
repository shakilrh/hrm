<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AwardType extends Model
{
    public function awards()
    {
        return $this->hasMany(Award::class);
    }
}
