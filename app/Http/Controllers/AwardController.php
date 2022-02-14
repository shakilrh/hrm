<?php

namespace App\Http\Controllers;

use App\Award;
use App\Employee;
use App\AwardType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\NewAward;
use App\DataTables\AwardDataTable;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AwardDataTable $dataTable)
    {
        return $dataTable->render('award.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $awardTypes = AwardType::all();
        if (Auth::user()->hasRole('employee')) {
            return view('award.form', compact('awardTypes'));
        } else {
            $employees = Employee::all();
            return view('award.form', compact('employees', 'awardTypes'));
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
            'award_type' => 'required',
            'gift_item' => 'required',
            'cash_price' => 'required',
        ]);
        if (!Auth::user()->hasRole('employee')) {
            $this->validate($request, [
                'employee' => 'required',
            ]);
        }
        $award = new Award();
        $this->saveDate($request, $award);
        Toastr::success('Award Successfully Saved', 'Success');
        return redirect()->route('awards.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function show(Award $award)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function edit(Award $award)
    {
        $awardTypes = AwardType::all();
        if (Auth::user()->hasRole('employee')) {
            if ($award->employee->id == Auth::user()->employee->id) {
                return view('award.form', compact('award', 'awardTypes'));
            } else {
                Toastr::error('This award does not belongs to you', 'Error');
                return redirect()->route('awards.index');
            }
        } else {
            $employees = Employee::all();
            return view('award.form', compact('award', 'awardTypes', 'employees'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Award $award)
    {
        $this->validate($request, [
            'award_type' => 'required',
            'gift_item' => 'required',
            'cash_price' => 'required',
        ]);
        if (!Auth::user()->hasRole('employee')) {
            $this->validate($request, [
                'employee' => 'required',
            ]);
        }

        if (Auth::user()->hasRole('employee')) {
            if ($award->employee->id == Auth::user()->employee->id) {
                $this->saveDate($request, $award);
            } else {
                Toastr::error('This award does not belongs to you', 'Error');
                return redirect()->back();
            }
        } else {
            $this->saveDate($request, $award);
        }
        Toastr::success('Award Successfully Updated', 'Success');
        return redirect()->route('awards.index');
    }

    public function saveDate($request, $award)
    {
        if (Auth::user()->hasRole('employee')) {
            $award->employee_id = Auth::user()->employee->id;
        } else {
            $award->employee_id = $request->employee;
        }
        $award->award_type_id = $request->award_type;
        $award->gift_item = $request->gift_item;
        $award->cash_price = $request->cash_price;
        $award->date = Carbon::parse($request->date)->toDateString();
        $award->save();
        $award->employee->user->notify(new NewAward($award));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function destroy(Award $award)
    {
        if (Auth::user()->hasRole('employee')) {
            if ($award->employee->id == Auth::user()->employee->id) {
                $award->delete();
            } else {
                Toastr::error('This award does not belongs to you', 'Error');
                return redirect()->back();
            }
        } else {
            $award->delete();
        }
        Toastr::success('Award Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
