<?php

namespace App\Http\Controllers;

use App\Department;
use App\Designation;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\DataTables\DesignationDataTable;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DesignationDataTable $dataTable)
    {
        return $dataTable->render('designation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::select('id', 'name')->active()->get();
        return view('designation.form', compact('departments'));
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
            'department' => 'required',
            'name' => 'required|unique:designations',
        ]);
        $designation = new Designation();
        $designation->department_id = $request->department;
        $designation->name = $request->name;
        $designation->slug = str_slug($request->name);
        if ($request->status == true) {
            $designation->status = 1;
        } else {
            $designation->status = 0;
        }
        $designation->save();
        Toastr::success('Designation Successfully Added :)', 'Success');
        return response()->json([
            'data'   => $designation,
            'redirect' => route('designations.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        $departments = Department::select('id', 'name')->active()->get();
        return view('designation.form', compact('designation', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        $this->validate($request, [
            'department' => 'required',
            'name' => 'required|sometimes|unique:designations,name,'.$designation->id,
        ]);
        $designation->department_id = $request->department;
        $designation->name = $request->name;
        $designation->slug = str_slug($request->name);
        if ($request->status == true) {
            $designation->status = 1;
        } else {
            $designation->status = 0;
        }
        $designation->save();
        Toastr::success('Designation Successfully Updated :)', 'Success');
        return response()->json([
            'data'   => $designation,
            'redirect' => route('designations.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        Toastr::success('Designation Successfully Deleted :)', 'Success');
        return redirect()->back();
    }
}
