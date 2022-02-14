@extends('layouts.app')

@section('title','Employees')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>View / Edit Employee</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employee</a></li>
                        <li class="breadcrumb-item active">{{ isset($employee) ? 'Edit' : 'Create' }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="employee-details-tab" data-toggle="tab" href="#employee-details" role="tab" aria-controls="employee-details" aria-selected="true">Employee Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bank-info-tab" data-toggle="tab" href="#bank-info" role="tab" aria-controls="bank-info" aria-selected="false">Bank Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="document-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">Document</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="employee-details" role="tabpanel" aria-labelledby="employee-details-tab">
                            <div class="card card-primary card-outline">
                                <!-- /.card-header -->
                                <form role="form" method="POST" action="{{ isset($employee) ? route('employees.update',$employee->id) : route('employees.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    @if (isset($employee))
                                        @method('PUT')
                                    @endif
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="image">Image </label>
                                            <span class="required-field">*</span>
                                            <span class="help">e.g. "Image" (Unique For every User)</span>
                                            <input type="file" name="image" id="image" class="dropify {{ $errors->has('image') ? ' is-invalid' : '' }}" data-default-file="{{ Storage::disk('public')->url('users/'.$employee->user->image) ?? asset('storage/users/default.png') }}">
                                            @if ($errors->has('username'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="name">Name </label>
                                                    <span class="required-field">*</span>
                                                    <span class="help">e.g. "Jhon"</span>
                                                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"  placeholder="Enter Name" value="{{ $employee->user->name ?? old('name') }}">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="employee_code">Employee Code Or Id </label>
                                                    <span class="required-field">*</span>
                                                    <span class="help">e.g. "E-546814" (Unique For every User)</span>
                                                    <input type="text" name="employee_code" id="employee_code" class="form-control {{ $errors->has('employee_code') ? ' is-invalid' : '' }}"  placeholder="Enter Employee Code" value="{{ $employee->employee_code ?? old('employee_code') }}">
                                                    @if ($errors->has('employee_code'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('employee_code') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="email">Email </label>
                                                    <span class="required-field">*</span>
                                                    <span class="help">e.g. "employee@gmail.com" (Unique For every User)</span>
                                                    <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $employee->user->email ?? old('email') }}" placeholder="Enter Email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="username">Username </label>
                                                    <span class="required-field">*</span>
                                                    <span class="help">e.g. "employee" (Unique For every User)</span>
                                                    <input type="text" name="username" id="username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ $employee->user->username ?? old('username') }}" placeholder="Enter Username">
                                                    @if ($errors->has('username'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="password">Password </label>
                                                    <span class="help">Leave blank if you no need to change password</span>
                                                    <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="******">
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password </label>
                                                    <span class="help">Leave blank if you no need to change password</span>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="******">
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="branch">Select Branch</label>
                                                    <span class="required-field">*</span>
                                                    <select id="branch" class="form-control select2 {{ $errors->has('branch') ? ' is-invalid' : '' }}" name="branch" data-placeholder="Branch">
                                                        <option selected disabled>Select Branch</option>
                                                        @foreach($branches as $key=>$branch)
                                                            <option
                                                                @if(isset($employee))
                                                                {{ $employee->branch->id == $branch->id ? 'selected' : '' }}
                                                                @endif
                                                                @if (old('branch'))
                                                                {{ old('branch') == $branch->id ? 'selected' : '' }}
                                                                @endif
                                                                value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('branch'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('branch') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="date_of_join">Date Of Join</label>
                                                    <span class="required-field">*</span>
                                                    <input name="date_of_join" id="date_of_join" class="datepicker form-control {{ $errors->has('date_of_join') ? ' is-invalid' : '' }}" value="{{ $employee->date_of_join ?? old('date_of_join') }}" placeholder="Joining Date">
                                                    @if ($errors->has('date_of_join'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('date_of_join') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="department">Select Department</label>
                                                    <span class="required-field">*</span>
                                                    <select id="department" class="form-control {{ $errors->has('department') ? ' is-invalid' : '' }}" name="department" data-placeholder="Choose Department">
                                                        <option></option>
                                                        @foreach($departments as $key=>$department)
                                                            <option
                                                                @if(isset($employee))
                                                                {{ $employee->department->id == $department->id ? 'selected' : '' }}
                                                                @endif
                                                                {{ old('department') == $department->id ? 'selected' : '' }}
                                                                value="{{ $department->id }}">{{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('department'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('department') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="designation">Select Designation</label>
                                                    <span class="required-field">*</span>
                                                    <select id="designation" class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" name="designation" data-placeholder="Designation" data-readonly="Choose Department First">
                                                        <option></option>
                                                        @if (isset($designations))
                                                            @foreach($designations as $key=>$designation)
                                                                <option
                                                                    @if(isset($employee))
                                                                    {{ $employee->designation->id == $designation->id ? 'selected' : '' }}
                                                                    @endif
                                                                    value="{{ $designation->id }}">{{ $designation->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('designation'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('designation') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="basic_salary">Basic Salary</label>
                                                    <span class="required-field">*</span>
                                                    <input type="number" name="basic_salary" id="basic_salary" class="form-control {{ $errors->has('basic_salary') ? ' is-invalid' : '' }}" value="{{ $employee->basic_salary ?? old('basic_salary') }}" placeholder="Salary Rate" required>
                                                    @if ($errors->has('basic_salary'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('basic_salary') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                 <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <span class="required-field">*</span>
                                                    <select id="gender" class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" >
                                                        <option selected disabled>Select Gender</option>
                                                        @foreach($employeeGenders as $gender)
                                                            <option
                                                                @if(isset($employee))
                                                                {{ $employee->gender === $gender ? 'selected' : '' }}
                                                                @endif
                                                                {{ old('gender') == $gender ? 'selected' : '' }}
                                                                value="{{ $gender }}">{{ \App\Enums\EmployeeGender::getKey($gender) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('gender'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('gender') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="date_of_birth">Date Of Birth</label>
                                                    <span class="required-field">*</span>
                                                    <input name="date_of_birth" id="date_of_birth" class="datepicker form-control {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" value="{{ $employee->date_of_birth ?? old('date_of_birth') }}" placeholder="Bitth Date" required autocomplete="off">
                                                    @if ($errors->has('date_of_birth'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('date_of_birth') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="phone">Phone </label>
                                                    <span class="required-field">*</span>
                                                    <input type="text" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"  placeholder="Enter phone" value="{{ $employee->phone ?? old('phone') }}" required>
                                                    @if ($errors->has('phone'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="alt_phone">Alt Phone </label>
                                                    <span class="help">Optional</span>
                                                    <input type="text" name="alt_phone" id="alt_phone" class="form-control {{ $errors->has('alt_phone') ? ' is-invalid' : '' }}"  placeholder="Enter Alt Phone" value="{{ $employee->alt_phone ?? old('alt_phone') }}">
                                                    @if ($errors->has('alt_phone'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('alt_phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="father_name">Father Name </label>
                                                    <input type="text" name="father_name" id="father_name" class="form-control {{ $errors->has('father_name') ? ' is-invalid' : '' }}"  placeholder="Enter Father Name" value="{{ $employee->father_name ?? old('father_name') }}">
                                                    @if ($errors->has('father_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('father_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="mother_name">Mother Name </label>
                                                    <input type="text" name="mother_name" id="mother_name" class="form-control {{ $errors->has('mother_name') ? ' is-invalid' : '' }}"  placeholder="Enter Mother Name" value="{{ $employee->mother_name ?? old('mother_name') }}">
                                                    @if ($errors->has('mother_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('mother_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="present_address">Present Address </label>
                                                    <textarea name="present_address" id="present_address" class="form-control {{ $errors->has('present_address') ? ' is-invalid' : '' }}" rows="3" >{{ $employee->present_address ?? old('present_address') }}</textarea>
                                                    @if ($errors->has('present_address'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('present_address') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="permanent_address">Permanent Address </label>
                                                    <textarea name="permanent_address" id="permanent_address" class="form-control {{ $errors->has('permanent_address') ? ' is-invalid' : '' }}" rows="3" >{{ $employee->permanent_address ?? old('permanent_address') }}</textarea>
                                                    @if ($errors->has('permanent_address'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('permanent_address') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="status">Employee Status</label>
                                                    <span class="required-field">*</span>
                                                    <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" >
                                                        <option selected disabled>Select Status</option>
                                                        @foreach($employeeStatus as $status)
                                                            <option
                                                                @if(isset($employee))
                                                                {{ $employee->user->status === $status ? 'selected' : '' }}
                                                                @endif
                                                                @if(old('status'))
                                                                {{ old('status') == $status ? 'selected' : '' }}
                                                                @endif
                                                                value="{{ $status }}">{{ \App\Enums\UserStatus::getKey($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="date_of_leave">Date Of Leave</label>
                                                    <span class="help">If employee Resigned</span>
                                                    <input name="date_of_leave" id="date_of_leave" class="form-control" value="{{ $employee->date_of_leave ?? '' }}" placeholder="Date Of Leave" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <a href="{{ route('employees.index') }}" class="btn btn-danger pull-right">
                                            <i class="fas fa-chevron-circle-left"></i>
                                            <span>Back</span>
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i>
                                            <span>Update</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="bank-info" role="tabpanel" aria-labelledby="bank-info-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">All Banks Accounts.</h3>
                                            <div class="card-tools">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBankInfoModal">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Add New Bank</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="addBankInfoModal" tabindex="-1" role="dialog" aria-labelledby="addBankInfoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addBankInfoModalLabel">Add New Bank</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form role="form" method="POST" action="{{  route('employees.bank.store',$employee->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="bank_name">Bank Name </label>
                                                            <span class="required-field">*</span>
                                                            <span class="help">e.g. "Citibank Ltd."</span>
                                                            <input type="text" name="bank_name" id="bank_name" class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}"  placeholder="Enter bank name" value="{{ old('bank_name') }}">
                                                            @if ($errors->has('bank_name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('bank_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="branch_name">Branch Name </label>
                                                            <span class="required-field">*</span>
                                                            <input type="text" name="branch_name" id="branch_name" class="form-control {{ $errors->has('branch_name') ? ' is-invalid' : '' }}"  placeholder="Enter branch name" value="{{ old('branch_name') }}">
                                                            @if ($errors->has('branch_name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('branch_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="holder_name">Holder Name </label>
                                                            <span class="required-field">*</span>
                                                            <span class="help">e.g. "John"</span>
                                                            <input type="text" name="holder_name" id="holder_name" class="form-control {{ $errors->has('holder_name') ? ' is-invalid' : '' }}"  placeholder="Enter holder name" value="{{ old('holder_name') }}">
                                                            @if ($errors->has('holder_name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('holder_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="account_number">Account Number </label>
                                                            <span class="required-field">*</span>
                                                            <span class="help">e.g. "1015463115661214"</span>
                                                            <input type="text" name="account_number" id="account_number" class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}"  placeholder="Enter account number" value="{{ old('account_number') }}">
                                                            @if ($errors->has('account_number'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('account_number') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ifsc_code">IFSC Code </label>
                                                            <input type="text" name="ifsc_code" id="ifsc_code" class="form-control {{ $errors->has('ifsc_code') ? ' is-invalid' : '' }}"  placeholder="Enter ifsc code" value="{{ old('ifsc_code') }}">
                                                            @if ($errors->has('ifsc_code'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('ifsc_code') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pan_number">PAN Number </label>
                                                            <input type="text" name="pan_number" id="pan_number" class="form-control {{ $errors->has('pan_number') ? ' is-invalid' : '' }}"  placeholder="Enter pan number" value="{{ old('pan_number') }}">
                                                            @if ($errors->has('pan_number'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('pan_number') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Bank Name</th>
                                                    <th>Branch</th>
                                                    <th>Holder</th>
                                                    <th>Account Number</th>
                                                    <th>IFSC Code</th>
                                                    <th>PAN Number</th>
                                                    @role('admin')
                                                    <th>Timestamp</th>
                                                    @endrole
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($employeeBanks as $key=>$bank)
                                                    <tr>
                                                        <td>{{ $bank->bank_name }}</td>
                                                        <td>{{ $bank->branch_name }}</td>
                                                        <td>{{ $bank->holder_name }}</td>
                                                        <td>{{ $bank->account_number }}</td>
                                                        <td>{{ $bank->ifsc_code }}</td>
                                                        <td>{{ $bank->pan_number }}</td>
                                                        @role('admin')
                                                        <td>{{ $bank->updated_at }}</td>
                                                        @endrole
                                                        <td class="text-center">
                                                            {{--edit action--}}
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editBankInfoModal-{{ $bank->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <div class="modal fade text-left" id="editBankInfoModal-{{ $bank->id }}" tabindex="-1" role="dialog" aria-labelledby="editBankInfoModalLabel-{{ $bank->id }}" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editBankInfoModalLabel-{{ $bank->id }}">Edit Bank Info</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form role="form" method="POST" action="{{  route('employees.bank.update',['employeeId'=>$employee->id,'id'=>$bank->id]) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="bank_name">Bank Name </label>
                                                                                    <span class="required-field">*</span>
                                                                                    <span class="help">e.g. "Citibank Ltd."</span>
                                                                                    <input type="text" name="bank_name" id="bank_name" class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}"  placeholder="Enter bank name" value="{{ $bank->bank_name }}">
                                                                                    @if ($errors->has('bank_name'))
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $errors->first('bank_name') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="branch_name">Branch Name </label>
                                                                                    <span class="required-field">*</span>
                                                                                    <input type="text" name="branch_name" id="branch_name" class="form-control {{ $errors->has('branch_name') ? ' is-invalid' : '' }}"  placeholder="Enter branch name" value="{{ $bank->branch_name }}">
                                                                                    @if ($errors->has('branch_name'))
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $errors->first('branch_name') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="holder_name">Holder Name </label>
                                                                                    <span class="required-field">*</span>
                                                                                    <span class="help">e.g. "John"</span>
                                                                                    <input type="text" name="holder_name" id="holder_name" class="form-control {{ $errors->has('holder_name') ? ' is-invalid' : '' }}"  placeholder="Enter holder name" value="{{ $bank->holder_name }}">
                                                                                    @if ($errors->has('holder_name'))
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $errors->first('holder_name') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="account_number">Account Number </label>
                                                                                    <span class="required-field">*</span>
                                                                                    <span class="help">e.g. "1015463115661214"</span>
                                                                                    <input type="text" name="account_number" id="account_number" class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}"  placeholder="Enter account number" value="{{ $bank->account_number }}">
                                                                                    @if ($errors->has('account_number'))
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $errors->first('account_number') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="ifsc_code">IFSC Code </label>
                                                                                    <input type="text" name="ifsc_code" id="ifsc_code" class="form-control {{ $errors->has('ifsc_code') ? ' is-invalid' : '' }}"  placeholder="Enter ifsc code" value="{{ $bank->ifsc_code }}">
                                                                                    @if ($errors->has('ifsc_code'))
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $errors->first('ifsc_code') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="pan_number">PAN Number </label>
                                                                                    <input type="text" name="pan_number" id="pan_number" class="form-control {{ $errors->has('pan_number') ? ' is-invalid' : '' }}"  placeholder="Enter pan number" value="{{ $bank->pan_number }}">
                                                                                    @if ($errors->has('pan_number'))
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $errors->first('pan_number') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Update changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--delete action--}}
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteBank({{ $bank->id }})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                            <form id="delete-bank-form-{{ $bank->id }}" action="{{ route('employees.bank.destroy',['employeeId'=>$employee->id,'id'=>$bank->id]) }}" method="POST" style="display: none;">
                                                                @csrf()
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="8"><strong>No Data found.</strong></td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-primary card-outline">
                                        <!-- /.card-header -->
                                        <form role="form" method="POST" action="{{  route('employees.document.store',$employee->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="document_name">Document Name </label>
                                                    <span class="required-field">*</span>
                                                    <span class="help">e.g. "Resume, Joining Letter etc"</span>
                                                    <input type="text" name="document_name" id="document_name" class="form-control {{ $errors->has('document_name') ? ' is-invalid' : '' }}"  placeholder="Enter document name" value="{{ old('document_name') }}">
                                                    @if ($errors->has('document_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('document_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="file">Select Document </label>
                                                    <span class="required-field">*</span>
                                                    <input type="file" name="file" id="file" class="dropify {{ $errors->has('file') ? ' is-invalid' : '' }}">
                                                    @if ($errors->has('file'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('file') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <a href="{{ route('employees.index') }}" class="btn btn-danger pull-right">
                                                    <i class="fas fa-chevron-circle-left"></i>
                                                    <span>Back</span>
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i>
                                                    <span>Submit</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">All Documents.</h3>
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table id="datatable" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    @role('admin')
                                                    <th>Uploaded At</th>
                                                    @endrole
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($employeeDocuments as $key=>$document)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $document->name }}</td>
                                                        @role('admin')
                                                        <td>{{ $document->created_at }}</td>
                                                        @endrole
                                                        <td class="text-center">
                                                            <a class="btn btn-primary btn-sm" href="{{ Storage::disk('public')->url('documents/'.$document->file) }}" download>
                                                                <i class="fas fa-download"></i>
                                                                <span>Download</span>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteDocument({{ $document->id }})">
                                                                <i class="fas fa-trash-alt"></i>
                                                                <span>Delete</span>
                                                            </button>
                                                            <form id="delete-document-form-{{ $document->id }}" action="{{ route('employees.document.destroy',['employeeId'=>$employee->id,'id'=>$document->id]) }}" method="POST" style="display: none;">
                                                                @csrf()
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    @role('admin')
                                                    <th>Uploaded At</th>
                                                    @endrole
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        jQuery(document).ready(function(){
            // Select2
            $("#department").select2({
                placeholder: "Choose Department",
                allowClear: true
            });
            $("#designation").select2({
                placeholder: "Choose Department First",
                allowClear: true,
            });
        });
        $('#department').on('select2:select', function (e) {
            let id = $('#department').find(':selected').val();
            $('#designation').empty().trigger("change");
            getDesignation(id);
        });

        $("#datatable").DataTable();

        function getDesignation(id) {
            axios.get('/departments/'+id+'/get-designation')
                .then(function (response) {
                    if (!response.data.length <= 0) {
                        for (let i = 0; i < response.data.length; i++) {
                            let obj = response.data[i];
                            let option = new Option(obj.name, obj.id, true);
                            $('#designation').append(option).trigger('change');
                        }
                        toastr.success('Designation Successfully Loaded.','Success');
                    }else {
                        toastr.warning('No Designation Found for This Department','Not Found');
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        function deleteDocument(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });
            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-document-form-'+id).submit();
                    swalWithBootstrapButtons(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'info'
                    )
                }
            })
        }
        function deleteBank(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });
            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-bank-form-'+id).submit();
                    swalWithBootstrapButtons(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'info'
                    )
                }
            })
        }

    </script>
@endpush
