<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use App\DataTables\BranchDataTable;
use Brian2694\Toastr\Facades\Toastr;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BranchDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(BranchDataTable $dataTable)
    {
        return $dataTable->render('branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branch.form');
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
            'name' => 'required|unique:branches',
            'address' => 'required'
        ]);
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->slug = str_slug($request->name);
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        if ($request->status == true) {
            $branch->status = 1;
        } else {
            $branch->status = 0;
        }
        $branch->save();
        Toastr::success('Branch Successfully Saved :)', 'Success');
        return response()->json([
            'data'   => $branch,
            'redirect' => route('branches.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        return view('branch.form', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $this->validate($request, [
            'name' => 'required|sometimes|unique:branches,name,'.$branch->id,
            'address' => 'required',
        ]);
        $branch->name = $request->name;
        $branch->slug = str_slug($request->name);
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        if ($request->status == true) {
            $branch->status = 1;
        } else {
            $branch->status = 0;
        }
        $branch->save();
        Toastr::success('Branch Successfully update :)', 'Success');
        return response()->json([
            'data'   => $branch,
            'redirect' => route('branches.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        Toastr::success('Branch Successfully Deleted :)', 'Success');
        return redirect()->back();
    }
}
