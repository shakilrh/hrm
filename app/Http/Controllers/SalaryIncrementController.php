<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\SalaryIncrementDataTable;

class SalaryIncrementController extends Controller
{
    public function index(SalaryIncrementDataTable $dataTable)
    {
        return $dataTable->render('payroll.salary.increment');
    }
}
