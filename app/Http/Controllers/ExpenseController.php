<?php

namespace App\Http\Controllers;

use App\User;
use App\Expense;
use App\Employee;
use Notification;
use Carbon\Carbon;
use App\Traits\FileHandler;
use App\Enums\ExpenseStatus;
use Illuminate\Http\Request;
use App\DataTables\ExpenseDataTable;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewExpenseRequest;
use App\Notifications\ExpenseRequestStatus;

class ExpenseController extends Controller
{
    use FileHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseDataTable $dataTable)
    {
        return $dataTable->render('expense.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenseStatus = ExpenseStatus::toArray();
        if (Auth::user()->hasRole('employee')) {
            return view('expense.form', compact('expenseStatus'));
        } else {
            $employees = Employee::all();
            return view('expense.form', compact('expenseStatus', 'employees'));
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
            'item_name' => 'required',
            'purchase_from' => 'required',
            'purchase_date' => 'required',
            'amount' => 'required|numeric',
        ]);
        if (!Auth::user()->hasRole('employee')) {
            $this->validate($request, [
                'purchase_by' => 'required',
                'status' => 'required',
            ]);
        }
        $file = $request->file('bill_copy');
        $namePrefix = str_slug($request->item_name);
        $this->uploadFile($file, 'expense', $namePrefix);
        $expense = new Expense();
        $this->saveData($request, $expense);
        Toastr::success('Expense Successfully Saved', 'Success');
        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $expenseStatus = ExpenseStatus::toArray();
        if (Auth::user()->hasRole('employee')) {
            if ($expense->employee->id == Auth::user()->employee->id) {
                return view('expense.form', compact('expense', 'expenseStatus'));
            } else {
                Toastr::error('This leave expense does not belongs to you', 'Error');
                return redirect()->route('expenses.index');
            }
        } else {
            $employees = Employee::all();
            return view('expense.form', compact('expense', 'expenseStatus', 'employees'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $this->validate($request, [
            'item_name' => 'required',
            'purchase_from' => 'required',
            'purchase_date' => 'required',
            'amount' => 'required|numeric',
        ]);
        if (!Auth::user()->hasRole('employee')) {
            $this->validate($request, [
                'purchase_by' => 'required',
                'status' => 'required',
            ]);
        }
        $file = $request->file('bill_copy');
        $namePrefix = str_slug($request->item_name);
        $this->uploadFile($file, 'expense', $namePrefix, $expense->bill_copy);
        $this->saveData($request, $expense);
        Toastr::success('Expense Successfully Updated', 'Success');
        return redirect()->route('expenses.index');
    }

    public function saveData($request, $expense)
    {
        if (Auth::user()->hasRole('employee')) {
            $expense->employee_id = Auth::user()->employee->id;
            $expense->status = ExpenseStatus::Pending;
        } else {
            $expense->employee_id = $request->purchase_by;
            $expense->status = $request->status;
        }
        $expense->item_name = $request->item_name;
        $expense->purchase_from = $request->purchase_from;
        $expense->purchase_date = Carbon::parse($request->purchase_date)->toDateString();
        $expense->amount = $request->amount;
        $expense->bill_copy = $this->fileName;
        $expense->save();

        if (Auth::user()->hasRole('employee')) {
            $users = User::role('admin')->get();
            Notification::send($users, new NewExpenseRequest($expense));
        } else {
            $expense->employee->user->notify(new ExpenseRequestStatus($expense));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        if (Auth::user()->hasRole('employee')) {
            if ($expense->employee->id == Auth::user()->employee->id) {
                $this->deleteFile($expense->bill_copy, 'expense');
                $expense->delete();
            } else {
                Toastr::error('This expense does not belongs to you', 'Error');
                return redirect()->back();
            }
        } else {
            $this->deleteFile($expense->bill_copy, 'expense');
            $expense->delete();
        }
        Toastr::success('Expendes Successfully Deleted.', 'Success');
        return redirect()->back();
    }
}
