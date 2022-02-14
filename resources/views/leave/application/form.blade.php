@extends('layouts.app')

@section('title','Leave')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($leaveApplication) ? 'Updated' : 'Add New' }} Leave</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('leave.applications.index') }}">Leave</a></li>
                        <li class="breadcrumb-item active">{{ isset($leaveApplication) ? 'Update' : 'Create' }}</li>
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
                        <form role="form" method="POST" action="{{ isset($leaveApplication) ? route('leave.applications.update',$leaveApplication->id) : route('leave.applications.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($leaveApplication))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                @unlessrole('employee')
                                <div class="form-group">
                                    <label for="employee">Employee</label>
                                    <span class="required-field">*</span>
                                    <select id="employee" class="form-control select2 {{ $errors->has('employee') ? ' is-invalid' : '' }}" name="employee" required>
                                        <option selected disabled>Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option
                                                @if(isset($leaveApplication->employee->id))
                                                    {{ $leaveApplication->employee->id === $employee->id ? 'selected' : '' }}
                                                @endif
                                                value="{{ $employee->id }}">{{ $employee->user->name }} ({{ $employee->employee_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('employee'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('employee') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @endunlessrole
                                <div class="form-group">
                                    <label for="leave_type">Leave Type</label>
                                    <span class="required-field">*</span>
                                    <select id="leave_type" class="form-control select2 {{ $errors->has('leave_type') ? ' is-invalid' : '' }}" name="leave_type" required>
                                        <option selected disabled>Select Leave Type</option>
                                        @foreach($leaveTypes as $leaveType)
                                            <option
                                                @if(isset($leaveApplication->type->id))
                                                    {{ $leaveApplication->type->id === $leaveType->id ? 'selected' : '' }}
                                                @endif
                                                value="{{ $leaveType->id }}">{{ $leaveType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('leave_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('leave_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="leave_form">Leave Form</label>
                                    <span class="required-field">*</span>
                                    <input name="leave_form" id="leave_form" class="datepicker form-control {{ $errors->has('leave_form') ? ' is-invalid' : '' }}" value="{{ $leaveApplication->leave_form ?? old('leave_form') }}" placeholder="Leave Form" autocomplete="off" required>
                                    @if ($errors->has('leave_form'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('leave_form') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="leave_to">Leave To</label>
                                    <span class="required-field">*</span>
                                    <input name="leave_to" id="leave_to" class="datepicker form-control {{ $errors->has('leave_to') ? ' is-invalid' : '' }}" value="{{ $leaveApplication->leave_to ?? old('leave_to') }}" placeholder="Leave To" autocomplete="off" required>
                                    @if ($errors->has('leave_to'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('leave_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                @unlessrole('employee')
                                <div class="form-group">
                                    <label for="status">Leave Status</label>
                                    <span class="required-field">*</span>
                                    <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" required>
                                        <option selected disabled>Select Status</option>
                                        @foreach($leaveStatus as $status)
                                            <option
                                                @if(isset($leaveApplication))
                                                    {{ $leaveApplication->status === $status ? 'selected' : '' }}
                                                @endif
                                                value="{{ $status }}">{{ \App\Enums\LeaveStatus::getKey($status) }}</option>
                                        @endforeach
                                    </select>
                                     @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @endunlessrole
                                <div class="form-group">
                                    <label for="leave_reason">Leave Reason</label>
                                    <textarea class="form-control {{ $errors->has('leave_reason') ? ' is-invalid' : '' }}" id="leave_reason" name="leave_reason" rows="5">{{ isset($leaveApplication) ? $leaveApplication->leave_reason : old('leave_reason') }}</textarea>
                                     @if ($errors->has('leave_reason'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('leave_reason') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('leave.applications.index') }}" class="btn btn-danger pull-right">
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

@endpush
