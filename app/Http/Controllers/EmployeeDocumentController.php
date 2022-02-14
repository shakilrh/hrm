<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeDocument;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class EmployeeDocumentController extends Controller
{
    use FileHandler;
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
     * @param  \Illuminate\Http\Request  $request $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'document_name' => 'required',
            'file' => 'required'
        ]);
        $employee = Employee::findOrFail($id);
        $file = $request->file('file');
        $namePrefix = str_slug($request->document_name).'-'.$employee->user->username;
        $this->uploadFile($file, 'documents', $namePrefix);
        $document = new EmployeeDocument();
        $document->employee_id = $employee->id;
        $document->name = $request->document_name;
        $document->file = $this->fileName;
        $document->save();
        Toastr::success('Document Successfully Uploaded', 'Success');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param  int $employeeId
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId, $id)
    {
        $document = EmployeeDocument::findOrFail($id);
        if ($document->employee->id == $employeeId) {
            $this->deleteFile($document->file, 'documents');
            $document->delete();
            Toastr::success('Document Successfully Deleted.', 'Success');
        } else {
            Toastr::error('Something went wong try again.', 'Error');
        }
        return redirect()->back();
    }
}
