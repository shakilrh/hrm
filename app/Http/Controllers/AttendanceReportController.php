<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Attendance;
use App\AttendanceData;
use Illuminate\Http\Request;
use App\Enums\AttendanceOption;
use Illuminate\Support\Facades\Auth;

class AttendanceReportController extends Controller
{
    protected $data;

    public function index(Request $request)
    {
        $this->validate($request, [
            'form' => 'required',
            'to' => 'required',
        ]);
        if (Auth::user()->hasRole('employee')) {
            $employee = Auth::user()->employee;

            $this->report($employee, $request->form, $request->to);
            return view('attendance.report.index', $this->data);
        } else {
            $this->validate($request, [
                'employee' => 'required'
            ]);
            $employee = Employee::findOrFail($request->employee);
            $this->report($employee, $request->form, $request->to);
            return view('attendance.report.index', $this->data);
        }
    }

    public function print()
    {
        if (Auth::user()->hasRole('employee')) {
            $employee = Auth::user()->employee;
            $this->report($employee, request()->form, request()->to);
            return view('attendance.report.print', $this->data);
        } else {
            $employee = Employee::findOrFail(request()->employee);
            $this->report($employee, request()->form, request()->to);
            return view('attendance.report.print', $this->data);
        }
    }

    public function report($employee, $form, $to)
    {
        $data['employee'] = $employee;

        $data['attendanceData'] =  AttendanceData::whereHas(
            'attendance',
            function ($query) use ($form,$to) {
                $query->whereBetween('date', [$form,$to]);
            }
            )->where('employee_id', $employee->id)->get();

        $data['totalDays'] = $data['attendanceData']->count();
        $data['totalPresent'] = $data['attendanceData']
                                    ->where('status', AttendanceOption::Present)->count();
        $data['totalAbsence'] = $data['attendanceData']
                                    ->where('status', AttendanceOption::Absence)->count();
        $data['totalLeave'] = $data['attendanceData']
                                    ->where('status', AttendanceOption::Leave)->count();
        return $this->data = $data;
    }
}
