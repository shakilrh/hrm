<?php

namespace App\Http\Controllers;

use App\User;
use App\Branch;
use App\Employee;
use Carbon\Carbon;
use App\Department;
use App\Designation;
use App\Enums\SalaryType;
use App\Enums\UserStatus;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use App\Enums\EmployeeGender;
use Brian2694\Toastr\Facades\Toastr;
use App\DataTables\EmployeeDataTable;

class EmployeeController extends Controller
{
    use  FileHandler;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeeDataTable $dataTable)
    {
        return $dataTable->render('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employeeStatus'] = UserStatus::getValues();
        $data['employeeGenders'] = EmployeeGender::getValues();
        $data['salaryTypes'] = SalaryType::getValues();
        $data['branches'] = Branch::active()->select('id', 'name')->get();
        $data['departments'] = Department::select('id', 'name')->get();
        return view('employee.create', $data);
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
            'image' => 'image',
            'name' => 'required|string|max:255',
            'employee_code' => 'required|unique:employees',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'branch' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'basic_salary' => 'required',
            'date_of_join' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'status' => 'required',
        ]);
        $username = str_slug($request->username);
        $image = $request->file('image');
        $this->uploadImage($image, 'users', $username, '200', '200');
//        create User info for employee
        $user = new User();
        $user->name = $request->name;
        $user->username = str_slug($request->username);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->image = $this->fileName;
        $user->status = $request->status;
        $user->save();
        $user->assignRole('employee');
//        Store employee data
        $employee = new Employee();
        $employee->user_id = $user->id;
        $employee->branch_id = $request->branch;
        $employee->department_id = $request->department;
        $employee->designation_id = $request->designation;
        $employee->employee_code =$request->employee_code;
        $employee->phone = $request->phone;
        $employee->alt_phone = $request->alt_phone;
        $employee->father_name = $request->father_name;
        $employee->mother_name = $request->mother_name;
        $employee->gender = $request->gender;
        $employee->date_of_birth = Carbon::parse($request->date_of_birth)->toDateString();
        $employee->present_address = $request->present_address;
        $employee->permanent_address = $request->permanent_address;
        $employee->date_of_join = Carbon::parse($request->date_of_join)->toDateString();
        $employee->basic_salary = $request->basic_salary;
        $employee->save();
        Toastr::success('Employee Successfully Created.', 'Success');
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $data['employee'] = $employee;
        $data['branches'] = Branch::active()->select('id', 'name')->get();
        $data['employeeGenders'] = EmployeeGender::getValues();
        $data['departments'] = Department::select('id', 'name')->get();
        $data['designations'] = Department::findOrFail($employee->department->id)->designations;
        $data['salaryTypes'] = SalaryType::getValues();
        $data['employeeStatus'] = UserStatus::getValues();
        $data['employeeBanks']  = $employee->bankInfos()->orderById()->get();
        $data['employeeDocuments']  = $employee->documents;
        return view('employee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'image' => 'image',
            'name' => 'required|string|max:255',
            'employee_code' => 'required|unique:employees,employee_code,'.$employee->id,
            'email' => 'required|email|unique:users,email,' .$employee->user->id,
            'username' => 'required|unique:users,username,' .$employee->user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'branch' => 'required',
            'gender' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'date_of_join' => 'required',
            'status' => 'required',
        ]);
        $username = str_slug($request->username);
        $image = $request->file('image');
        $this->uploadImage($image, 'users', $username, '200', '200', $employee->user->image);
//        update User for employee
        $user = User::findOrFail($employee->user->id);
        $user->name = $request->name;
        $user->username = str_slug($request->username);
        $user->email = $request->email;
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->image = $this->fileName;
        $user->status = $request->status;
        $user->save();
        //        Store employee data
        $employee->branch_id = $request->branch;
        $employee->department_id = $request->department;
        $employee->designation_id = $request->designation;
        $employee->employee_code = $request->employee_code;
        $employee->phone = $request->phone;
        $employee->alt_phone = $request->alt_phone;
        $employee->father_name = $request->father_name;
        $employee->mother_name = $request->mother_name;
        $employee->gender = $request->gender;
        $employee->date_of_birth = Carbon::parse($request->date_of_birth)->toDateString();
        $employee->present_address = $request->present_address;
        $employee->permanent_address = $request->permanent_address;
        $employee->date_of_join = Carbon::parse($request->date_of_join)->toDateString();
        if ($user->status == UserStatus::Resigned) {
            $employee->date_of_leave = Carbon::today()->toDateString();
        } else {
            $employee->date_of_leave = null;
        }
        $employee->basic_salary = $request->basic_salary;
        $employee->save();
        Toastr::success('Employee Successfully Updated.', 'Success');
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        User::findOrFail($employee->user->id)->delete();
        $employee->delete();
        Toastr::success('Employee Successfully Deleted.', 'Success');
        return redirect()->back();
    }
}
