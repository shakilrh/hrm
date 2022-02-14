@extends('layouts.app')

@section('title','Employees')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($employee) ? 'Edit' : 'Add New' }} Employee</h1>
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <!-- form start -->
                        {{--<employee-form></employee-form>--}}
                        <form user="form" method="POST" action="{{ isset($employee) ? route('employees.update',$employee->id) : route('employees.store') }}" enctype="multipart/form-data" >
                            @csrf
                            @if (isset($employee))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Image </label>
                                    <span class="required-field">*</span>
                                    <span class="help">e.g. "Image" (Unique For every User)</span>
                                    <input type="file" name="image" id="image" class="dropify {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name">Name </label>
                                            <span class="required-field">*</span>
                                            <span class="help">e.g. "Jhon"</span>
                                            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"  placeholder="Enter Name" value="{{ $employee->user->name ?? old('name') }}" autofocus required>
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
                                            <input type="text" name="employee_code" id="employee_code" class="form-control {{ $errors->has('employee_code') ? ' is-invalid' : '' }}"  placeholder="Enter Employee Code" value="{{ $employee->employee_code ?? old('employee_code') }}" required>
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
                                            <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $employee->user->email ?? old('email') }}" placeholder="Enter Email" required>
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
                                            <input type="text" name="username" id="username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ $employee->user->username ?? old('username') }}" placeholder="Enter Username" required>
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
                                            <span class="required-field">*</span>
                                            <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="******" required>
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
                                            <span class="required-field">*</span>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="******" required>
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
                                            <select id="branch" class="form-control select2 {{ $errors->has('branch') ? ' is-invalid' : '' }}" name="branch" data-placeholder="Branch" >
                                                <option></option>
                                                @foreach($branches as $key=>$branch)
                                                    <option
                                                        @if(isset($emplbranchoyee))
                                                        {{ $employee->branch->id == $branch->id ? 'selected' : '' }}
                                                        @endif
                                                        {{ old('branch') == $branch->id ? 'selected' : '' }}
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
                                            <input name="date_of_join" id="date_of_join" class="datepicker form-control {{ $errors->has('date_of_join') ? ' is-invalid' : '' }}" value="{{ $employee->date_of_join ?? old('date_of_join') }}" placeholder="Joining Date" required autocomplete="off">
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
                                                {{-- @foreach($departments as $key=>$department)
                                                     <option
                                                         @if(isset($employee))
                                                         {{ $employee->department->id == $department->id ? 'selected' : '' }}
                                                         @endif
                                                         value="{{ $department->id }}">{{ $department->name }}</option>
                                                 @endforeach--}}
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
                                            <select id="gender" class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">
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
                                <div class="form-group">
                                    <label for="status">Employee Status</label>
                                    <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" data-placeholder="Select Status" >
                                        <option></option>
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
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
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
    </script>
@endpush
