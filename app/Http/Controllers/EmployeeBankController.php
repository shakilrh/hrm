<?php

namespace App\Http\Controllers;

use App\EmployeeBankInfo;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EmployeeBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$employeeId)
    {
        $this->validate($request,[
            'bank_name' => 'required',
            'branch_name' => 'required',
            'holder_name' => 'required',
            'account_number' => 'required',
        ]);
        $employeeBankInfo = new EmployeeBankInfo();
        $employeeBankInfo->employee_id = $employeeId;
        $employeeBankInfo->bank_name = $request->bank_name;
        $employeeBankInfo->branch_name = $request->branch_name;
        $employeeBankInfo->holder_name = $request->holder_name;
        $employeeBankInfo->account_number = $request->account_number;
        $employeeBankInfo->ifsc_code = $request->ifsc_code;
        $employeeBankInfo->pan_number = $request->pan_number;
        $employeeBankInfo->save();
        Toastr::success('Bank Info Successfully Saved','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId,$id)
    {
        $this->validate($request,[
            'bank_name' => 'required',
            'branch_name' => 'required',
            'holder_name' => 'required',
            'account_number' => 'required',
        ]);
        $employeeBankInfo = EmployeeBankInfo::findOrFail($id);
        if($employeeBankInfo->employee->id == $employeeId)
        {
            $employeeBankInfo->employee_id = $employeeId;
            $employeeBankInfo->bank_name = $request->bank_name;
            $employeeBankInfo->branch_name = $request->branch_name;
            $employeeBankInfo->holder_name = $request->holder_name;
            $employeeBankInfo->account_number = $request->account_number;
            $employeeBankInfo->ifsc_code = $request->ifsc_code;
            $employeeBankInfo->pan_number = $request->pan_number;
            $employeeBankInfo->save();
            Toastr::success('Bank account successfully Update','Success');
        }else{
            Toastr::error('This bank account does not belongs to you','Error');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId,$id)
    {
        $bank = EmployeeBankInfo::findOrFail($id);
        if($bank->employee->id == $employeeId)
        {
            $bank->delete();
            Toastr::success('Bank account successfully deleted','Success');
        }else{
            Toastr::error('This bank account does not belongs to you','Error');
        }
        return redirect()->back();
    }
}
