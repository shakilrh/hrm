<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\DataTables\DepartmentDataTable;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DepartmentDataTable $dataTable)
    {
        return $dataTable->render('department.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::role('employee')->select('id', 'name')->get();
        return view('department.form', compact('users'));
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
            // 'head_of_department' => 'required',
            'name' => 'required|unique:departments',
        ]);
        $department = new Department();
        $department->user_id = $request->head_of_department;
        $department->name = $request->name;
        $department->slug = str_slug($request->name);
        if ($request->status == true) {
            $department->status = 1;
        } else {
            $department->status = 0;
        }
        $department->save();
        Toastr::success('Department Successfully Added :)', 'Success');
        return response()->json([
            'data'   => $department,
            'redirect' => route('departments.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function getDesignation($id)
    {
        return Department::findOrfail($id)->designations;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::with('user')->findOrFail($id);
        $users = User::role('employee')->select('id', 'name')->get();
        return view('department.form', compact('users', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            // 'head_of_department' => 'required',
            'name' => 'required|sometimes|unique:departments,name,'.$department->id,
        ]);
        $department->user_id = $request->head_of_department;
        $department->name = $request->name;
        $department->slug = str_slug($request->name);
        if ($request->status == true) {
            $department->status = 1;
        } else {
            $department->status = 0;
        }
        $department->save();
        Toastr::success('Department Successfully Updated :)', 'Success');
        return response()->json([
            'data'   => $department,
            'redirect' => route('departments.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        Toastr::success('Department Successfully Deleted :)', 'Success');
        return redirect()->back();
    }
}
