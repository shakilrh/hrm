<?php

namespace App\Http\Controllers;

use App\Employee;
use App\SalaryAllowance;
use App\SalaryDeduction;
use App\SalaryIncrement;
use Illuminate\Http\Request;
use App\DataTables\SalaryDataTable;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SalaryAllowanceUpdate;
use App\Notifications\SalaryDeductionUpdate;
use App\Notifications\SalaryIncrement as SalaryIncrementNotify;

class SalaryManagerController extends Controller
{
    public function index(SalaryDataTable $dataTable)
    {
        return $dataTable->render('payroll.salary.index');
    }

    public function manage($eCode)
    {
        $employee = Employee::where('employee_code', $eCode)->first();
        abort_unless($employee, '404');
        if (Auth::user()->hasRole('employee') && $employee->id != Auth::user()->employee->id) {
            Toastr::error('This does not belongs to you', 'Error');
            return redirect()->route('dashboard');
        }
        $salaryIncrements = $employee->salaryIncrements()->orderById()->get();
        return view('payroll.salary.manage', compact('employee', 'salaryIncrements'));
    }

    public function storeAllowance(Request $request, $eCode)
    {
        $this->validate($request, [
            'allowance_name' => 'required',
            'allowance_amount' => 'required|numeric',
        ]);
        $employee = Employee::where('employee_code', $eCode)->first();
        $allowance = new SalaryAllowance();
        $allowance->employee_id = $employee->id;
        $allowance->name = $request->allowance_name;
        $allowance->amount = $request->allowance_amount;
        $allowance->save();
        // notify employee
        $allowance->employee->user->notify(new SalaryAllowanceUpdate($allowance));
        Toastr::success('Allowance Successfully Added.', 'Success');
        return redirect()->back();
    }
    public function destroyAllowance($eCode, $id)
    {
        $employee = Employee::where('employee_code', $eCode)->first();
        $allowance = SalaryAllowance::findOrFail($id);
        if ($allowance->employee_id == $employee->id) {
            $allowance->delete();
            Toastr::success('Allowance Successfully Removed.', 'Success');
        } else {
            Toastr::error('This Allowance does not belongs to this employee', 'Error');
        }
        return redirect()->back();
    }

    public function storeDeduction(Request $request, $eCode)
    {
        $this->validate($request, [
            'deduction_name' => 'required',
            'deduction_amount' => 'required|numeric',
        ]);
        $employee = Employee::where('employee_code', $eCode)->first();
        $deduction = new SalaryDeduction();
        $deduction->employee_id = $employee->id;
        $deduction->name = $request->deduction_name;
        $deduction->amount = $request->deduction_amount;
        $deduction->save();
        // notify employee
        $deduction->employee->user->notify(new SalaryDeductionUpdate($deduction));
        Toastr::success('Deduction Successfully Added.', 'Success');
        return redirect()->back();
    }
    public function destroyDeduction($eCode, $id)
    {
        $employee = Employee::where('employee_code', $eCode)->first();
        $deduction = SalaryDeduction::findOrFail($id);
        if ($deduction->employee_id == $employee->id) {
            $deduction->delete();
            Toastr::success('Deduction Successfully Removed.', 'Success');
        } else {
            Toastr::error('This Deduction does not belongs to this employee', 'Error');
        }
        return redirect()->back();
    }

    public function storeIncrement(Request $request, $eCode)
    {
        $this->validate($request, [
            'increment_amount' => 'required|numeric',
        ]);
        $employee = Employee::where('employee_code', $eCode)->first();
        $employee->increment('basic_salary', $request->increment_amount);

        $increment = new SalaryIncrement();
        $increment->employee_id = $employee->id;
        $increment->amount = $request->increment_amount;
        $increment->remark = $request->remark;
        $increment->save();
        // notify employee
        $increment->employee->user->notify(new SalaryIncrementNotify($increment));
        Toastr::success('Increment Successfully Added.', 'Success');
        return redirect()->back();
    }
    public function destroyIncrement($eCode, $id)
    {
        $employee = Employee::where('employee_code', $eCode)->first();
        $increment = SalaryIncrement::findOrFail($id);
        if ($increment->employee_id == $employee->id) {
            $employee->decrement('basic_salary', $increment->amount);
            $increment->delete();
            Toastr::success('Increment Successfully Removed.', 'Success');
        } else {
            Toastr::error('This increment does not belongs to this employee', 'Error');
        }
        return redirect()->back();
    }
}
