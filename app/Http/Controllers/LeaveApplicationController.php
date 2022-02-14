<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use Notification;
use App\LeaveType;
use Carbon\Carbon;
use App\LeaveApplication;
use App\Enums\LeaveStatus;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewLeaveApplication;
use App\DataTables\LeaveApplicationDataTable;
use App\Notifications\LeaveApplicationStatus;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LeaveApplicationDataTable $dataTable)
    {
        return $dataTable->render('leave.application.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leaveStatus = LeaveStatus::toArray();
        $leaveTypes = LeaveType::all();
        if (Auth::user()->hasRole('employee')) {
            return view('leave.application.form', compact('leaveStatus', 'leaveTypes'));
        } else {
            $employees = Employee::all();
            return view('leave.application.form', compact('leaveStatus', 'employees', 'leaveTypes'));
        }
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
            'leave_type' => 'required',
            'leave_form' => 'required',
            'leave_to' => 'required',
        ]);
        if (!Auth::user()->hasRole('employee')) {
            $this->validate($request, [
                'employee' => 'required',
                'status' => 'required',
            ]);
        }
        $leaveApplication = new LeaveApplication();
        $this->saveDate($request, $leaveApplication);
        Toastr::success('Leave Application Successfully Saved', 'Success');
        return redirect()->route('leave.applications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LeaveApplication  $leaveApplication
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveApplication $leaveApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeaveApplication  $leaveApplication
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leaveApplication = LeaveApplication::findOrFail($id);
        $leaveStatus = LeaveStatus::toArray();
        $leaveTypes = LeaveType::all();
        if (Auth::user()->hasRole('employee')) {
            if ($leaveApplication->employee->id == Auth::user()->employee->id) {
                return view('leave.application.form', compact('leaveApplication', 'leaveStatus', 'leaveTypes'));
            } else {
                Toastr::error('This leave application does not belongs to you', 'Error');
                return redirect()->route('leave.applications.index');
            }
        } else {
            $employees = Employee::all();
            return view('leave.application.form', compact('leaveApplication', 'leaveStatus', 'employees', 'leaveTypes'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeaveApplication  $leaveApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'leave_type' => 'required',
            'leave_form' => 'required',
            'leave_to' => 'required',
        ]);
        if (!Auth::user()->hasRole('employee')) {
            $this->validate($request, [
                'employee' => 'required',
                'status' => 'required',
            ]);
        }
        $leaveApplication = LeaveApplication::findOrFail($id);
        if (Auth::user()->hasRole('employee')) {
            if ($leaveApplication->employee->id == Auth::user()->employee->id) {
                $this->saveDate($request, $leaveApplication);
            } else {
                Toastr::error('This leave application does not belongs to you', 'Error');
                return redirect()->back();
            }
        } else {
            $this->saveDate($request, $leaveApplication);
        }
        Toastr::success('Leave Application Successfully Updated', 'Success');
        return redirect()->route('leave.applications.index');
    }

    public function saveDate($request, $leaveApplication)
    {
        if (Auth::user()->hasRole('employee')) {
            $leaveApplication->employee_id = Auth::user()->employee->id;
            $leaveApplication->status = LeaveStatus::Pending;
        } else {
            $leaveApplication->employee_id = $request->employee;
            $leaveApplication->status = $request->status;
        }
        $leaveApplication->leave_type_id = $request->leave_type;
        $leaveApplication->leave_form = Carbon::parse($request->leave_form)->toDateString();
        $leaveApplication->leave_to = Carbon::parse($request->leave_to)->toDateString();
        $leaveApplication->leave_reason = $request->leave_reason;
        $leaveApplication->save();

        if (Auth::user()->hasRole('employee')) {
            $users = User::role('admin')->get();
            Notification::send($users, new NewLeaveApplication($leaveApplication));
        } else {
            $leaveApplication->employee->user->notify(new LeaveApplicationStatus($leaveApplication));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeaveApplication  $leaveApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leaveApplication = LeaveApplication::findOrFail($id);
        if (Auth::user()->hasRole('employee')) {
            if ($leaveApplication->employee->id == Auth::user()->employee->id) {
                $leaveApplication->delete();
            } else {
                Toastr::error('This leave application does not belongs to you', 'Error');
                return redirect()->back();
            }
        } else {
            $leaveApplication->delete();
        }

        Toastr::success('Leave Application Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
