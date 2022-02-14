<?php

namespace App\Http\Controllers;

use App\Award;
use App\Event;
use App\Branch;
use App\Notice;
use App\Expense;
use App\Employee;
use App\Department;
use App\AttendanceData;
use App\LeaveApplication;
use App\Traits\Authorize;
use Illuminate\Http\Request;
use App\Enums\AttendanceOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\ExpenseStatus;

class DashboardController extends Controller
{
    use Authorize;
    protected $data;

    public function index()
    {
        $currentMonth = date('m');
        if (Auth::user()->hasRole('employee')) {
            $this->employeeDashboardData($currentMonth);
        // return $this->data;
        } else {
            $this->dashboardData($currentMonth);
        }
        return view('dashboard', $this->data);
    }
    public function employeeDashboardData($currentMonth)
    {
        $employee = Auth::user()->employee;
        $currentYear = date('Y');
        // data counts
        $data['leaveApplicationCount'] = LeaveApplication::where('employee_id', $employee->id)->whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['expenseCount'] = Expense::where('employee_id', $employee->id)->whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['eventsCount'] = Event::whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['awardsCount'] = Award::where('employee_id', $employee->id)->whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        // attendance data
        $attendanceData = AttendanceData::whereHas(
            'attendance',
            function ($query) use ($currentMonth, $currentYear) {
                $query->whereYear('date', $currentYear)
                    ->whereMonth('date', $currentMonth)
                    ->orderBy('date', 'desc');
            }
        )->where('employee_id', $employee->id)->get();

        $data['totalDays'] = $attendanceData->count();
        $data['totalPresent'] = $attendanceData
            ->where('status', AttendanceOption::Present)->count();
        $data['totalAbsence'] = $attendanceData
            ->where('status', AttendanceOption::Absence)->count();
        $data['totalLeave'] = $attendanceData
            ->where('status', AttendanceOption::Leave)->count();

        // chart
        $data['expenses'] = Expense::select(DB::raw('SUM(amount) as total_expense, MONTH(purchase_date) as month, YEAR(purchase_date) as year'))
            ->groupBy(DB::raw('YEAR(purchase_date) ASC, MONTH(purchase_date) ASC'))->where('employee_id', $employee->id)->where('status',ExpenseStatus::Approved)->get();
        // recent data
        $data['recentLeaveApplications'] = LeaveApplication::where('employee_id', $employee->id)->OrderBy('id', 'desc')->take(5)->get();
        $data['recentExpenseRequests'] = Expense::where('employee_id', $employee->id)->OrderBy('id', 'desc')->take(5)->get();
        $this->data = $data;
    }

    public function dashboardData($currentMonth)
    {
        // data counts
        $data['employeesCount'] = Employee::all()->count();
        $data['leaveApplicationCount'] = LeaveApplication::whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['expenseCount'] = Expense::whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['eventsCount'] = Event::whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['noticeCount'] = Notice::whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['awardsCount'] = Award::whereRaw('MONTH(created_at) = ?', [$currentMonth])->count();
        $data['branchesCount'] = Branch::all()->count();
        $data['departmentsCount'] = Department::all()->count();
        // chart
        $data['expenses'] = Expense::select(DB::raw('SUM(amount) as total_expense, MONTH(purchase_date) as month, YEAR(purchase_date) as year'))
            ->groupBy(DB::raw('YEAR(purchase_date) ASC, MONTH(purchase_date) ASC'))->get();
        // recent data
        $data['recentLeaveApplications'] = LeaveApplication::OrderBy('id', 'desc')->take(5)->get();
        $data['recentExpenseRequests'] = Expense::OrderBy('id', 'desc')->take(5)->get();
        $this->data = $data;
    }
}
