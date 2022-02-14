<?php
/**
 * Created by PhpStorm.
 * User: cipfahim
 * Date: 9/26/18
 * Time: 3:08 PM
 */

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait Authorize
{
    public function authorizeCheck()
    {
        $routeName =  Route::current()->getName();
        if (!Auth::user()->hasPermissionTo($routeName))
        {
            abort(403);
        }
    }
}
