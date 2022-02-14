<?php

namespace App\Http\Controllers;

use App\Payslip;
use App\Employee;
use Carbon\Carbon;
use App\Attendance;
use App\Enums\Month;
use App\AttendanceData;
use App\Enums\PayslipStatus;
use Illuminate\Http\Request;
use App\Enums\AttendanceOption;
use App\DataTables\PayslipDataTable;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Payslip as AppPayslip;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(PayslipDataTable $dataTable)
    {
        if (Auth::user()->hasRole('employee')) {
            $payslips = Employee::findOrFail(Auth::user()->employee->id)->payslips;
            return view('payroll.payslip.index', compact('payslips'));
        } else {
            $data['employees'] = Employee::all();
            $data['months'] = Month::getValues();
            return $dataTable->render('payroll.payslip.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'employee' => 'required',
            'year' => 'required',
            'month' => 'required'
        ]);
        $count = Payslip::where('employee_id', $request->employee)
                        ->where('year', $request->year)
                        ->where('month', $request->month)->count();
        if ($count == 0) {
            $data['month'] = (int)$request->month;
            $data['year'] = (int)$request->year;
            $data['employee'] = Employee::findOrFail(request('employee'));
            abort_unless($data['employee'], 404);
            $attendanceData = AttendanceData::whereHas(
                'attendance',
                function ($query) use ($request) {
                    $query->whereYear('date', $request->year)
                        ->whereMonth('date', $request->month);
                }
            )->where('employee_id', $data['employee']->id)->get();
            $data['totalDays'] = $attendanceData->count();
            $data['totalPresent'] = $attendanceData
                                    ->where('status', AttendanceOption::Present)->count();
            $data['totalAbsence'] = $attendanceData
                                    ->where('status', AttendanceOption::Absence)->count();
            $data['totalLeave'] = $attendanceData
                                    ->where('status', AttendanceOption::Leave)->count();
            $data['payslipStatus'] = PayslipStatus::getValues();
        } else {
            Toastr::error('This Employee already got paid for this month', 'Already Exists');
            return redirect()->back();
        }
        return view('payroll.payslip.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee' => 'required',
            'year' => 'required',
            'month' => 'required',
            'status' => 'required',
        ]);
        $count = Payslip::where('employee_id', $request->employee)
                        ->where('year', $request->year)
                        ->where('month', $request->month)->count();
        if ($count == 0) {
            $payslip = new Payslip();
            $payslip->employee_id = $request->employee;
            $payslip->year = $request->year;
            $payslip->month = $request->month;
            $payslip->instant_deduction = $request->deduction_amount;
            $payslip->deduction_reason = $request->deduction_reason;
            $payslip->status = $request->status;
            $payslip->save();
            $payslip->employee->user->notify(new AppPayslip($payslip));
            Toastr::success('Payslip Successfully Saved', 'Success');
        } else {
            Toastr::error('This Employee already got paid for this month', 'Already Exists');
        }
        return redirect()->route('payroll.payslips.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function show(Payslip $payslip)
    {
        if (Auth::user()->hasRole('employee') && $payslip->employee->id != Auth::user()->employee->id) {
            Toastr::error('This payslip does not belongs to you', 'Error');
            return redirect()->route('payroll.payslips.index');
        }

        $data['payslip'] = $payslip;
        $data['employee'] = Employee::findOrFail($payslip->employee->id);

        $attendanceData = AttendanceData::whereHas(
            'attendance',
            function ($query) use ($payslip) {
                $query->whereYear('date', $payslip->year)
                        ->whereMonth('date', $payslip->month)
                        ->orderBy('date', 'desc');
            }
        )->where('employee_id', $payslip->employee->id)->get();
        $data['totalDays'] = $attendanceData->count();
        $data['totalPresent'] = $attendanceData
                                    ->where('status', AttendanceOption::Present)->count();
        $data['totalAbsence'] = $attendanceData
                                    ->where('status', AttendanceOption::Absence)->count();
        $data['totalLeave'] = $attendanceData
                                    ->where('status', AttendanceOption::Leave)->count();
        $data['payslipStatus'] = PayslipStatus::getValues();
        return view('payroll.payslip.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function edit(Payslip $payslip)
    {
        $data['payslip'] = $payslip;
        $data['employee'] = Employee::findOrFail($payslip->employee->id);

        $attendanceData = AttendanceData::whereHas(
            'attendance',
            function ($query) use ($payslip) {
                $query->whereYear('date', $payslip->year)
                        ->whereMonth('date', $payslip->month);
            }
        )->where('employee_id', $payslip->employee->id)->get();
        $data['totalDays'] = $attendanceData->count();
        $data['totalPresent'] = $attendanceData
                                    ->where('status', AttendanceOption::Present)->count();
        $data['totalAbsence'] = $attendanceData
                                    ->where('status', AttendanceOption::Absence)->count();
        $data['totalLeave'] = $attendanceData
                                    ->where('status', AttendanceOption::Leave)->count();
        $data['payslipStatus'] = PayslipStatus::getValues();
        return view('payroll.payslip.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payslip $payslip)
    {
        $this->validate($request, [
            'employee' => 'required',
            'year' => 'required',
            'month' => 'required',
            'status' => 'required',
        ]);
        $payslip->instant_deduction = $request->deduction_amount;
        $payslip->deduction_reason = $request->deduction_reason;
        $payslip->status = $request->status;
        $payslip->save();
        Toastr::success('Payslip Successfully updated', 'Success');
        return redirect()->route('payroll.payslips.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payslip $payslip)
    {
        $payslip->delete();
        Toastr::success('Payslip Successfully Deleted', 'Success');
        return redirect()->back();
    }

    public function print($id)
    {
        $payslip = Payslip::findOrFail($id);
        $data['payslip'] = $payslip;
        $data['employee'] = Employee::findOrFail($payslip->employee->id);

        $attendanceData = AttendanceData::whereHas(
            'attendance',
            function ($query) use ($payslip) {
                $query->whereYear('date', $payslip->year)
                        ->whereMonth('date', $payslip->month);
            }
        )->where('employee_id', $payslip->employee->id)->get();
        $data['totalDays'] = $attendanceData->count();
        $data['totalPresent'] = $attendanceData
                                    ->where('status', AttendanceOption::Present)->count();
        $data['totalAbsence'] = $attendanceData
                                    ->where('status', AttendanceOption::Absence)->count();
        $data['totalLeave'] = $attendanceData
                                    ->where('status', AttendanceOption::Leave)->count();
        $data['payslipStatus'] = PayslipStatus::getValues();
        return view('payroll.payslip.print', $data);
    }
}
