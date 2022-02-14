<?php
/**
 * Created by PhpStorm.
 * User: cipfahim
 * Date: 9/17/18
 * Time: 11:06 PM
 */

namespace App\Traits;


trait ModelScopes
{
    public function scopeActive($query)
    {
        return $query->where('status',true);
    }

    public function scopeOrderById($query)
    {
        return $query->orderBy('id','DESC');
    }
}
