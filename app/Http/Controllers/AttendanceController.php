<?php

namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Attendance;
use App\AttendanceData;
use Illuminate\Http\Request;
use App\Enums\AttendanceOption;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\DataTables\AttendanceDataTable;
use App\DataTables\AttendanceDataDataTable;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttendanceDataTable $attendanceTable, AttendanceDataDataTable $attendanceDataTable)
    {
        if (Auth::user()->hasRole('employee')) {
            return $attendanceDataTable->render('attendance.index');
        } else {
            $employees = Employee::with('user')->get();
            return $attendanceTable->render('attendance.index', compact('employees'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();
        $attendanceOptions = AttendanceOption::toArray();

        return view('attendance.form', compact('employees', 'attendanceOptions'));
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
            'date' => 'required|unique:attendances',
            'status.*'  => 'required',
        ]);
        // create new attendance
        $attendance = new Attendance();
        $attendance->date = Carbon::parse($request->date)->toDateString();
        $attendance->save();
        // store attendance data
        $employees = $request->employees;
        $status = $request->status;
        $remarks = $request->remarks;
        foreach ($employees as $key => $employee) {
            $attendanceData = new AttendanceData();
            $attendanceData->attendance_id = $attendance->id;
            $attendanceData->employee_id = $employee;
            $attendanceData->status = $status[$key];
            $attendanceData->remark = $remarks[$key];
            $attendanceData->save();
        }
        Toastr::success('Attendance Successfully Saved', 'Success');
        return redirect()->route('attendances.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        $attendanceOptions = AttendanceOption::toArray();
        return view('attendance.form', compact('attendance', 'employees', 'attendanceOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $this->validate($request, [
            'date' => 'required|unique:attendances,date,'.$attendance->id,
            'status.*' => 'required',
        ]);
        // create new attendance
        $attendance->date = Carbon::parse($request->date)->toDateString();
        $attendance->save();
        // store attendance data
        $employees = $request->employees;
        $status = $request->status;
        $remarks = $request->remarks;
        foreach ($employees as $key => $employee) {
            // $attendanceData = AttendanceData::where('employee_id', $employee)->first();
            $attendanceData = $attendance->data->where('employee_id', $employee)->first();
            $attendanceData->attendance_id = $attendance->id;
            $attendanceData->employee_id = $employee;
            $attendanceData->status = $status[$key];
            $attendanceData->remark = $remarks[$key];
            $attendanceData->save();
        }
        Toastr::success('Attendance Successfully Update', 'Success');
        return redirect()->route('attendances.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        Toastr::success('Attendance Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
