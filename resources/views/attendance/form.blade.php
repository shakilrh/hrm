@extends('layouts.app')

@section('title','Attendance')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Attendance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('attendances.index') }}">Attendance</a></li>
                        <li class="breadcrumb-item active">{{ isset($attendance) ? 'Update' : 'Create' }}</li>
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
                        {{-- <div class="card-header">
                            <h3 class="card-title">{{ isset($attendance) ? 'Updated' : 'Add New' }} Attendance</h3>
                        </div> --}}
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" role="form" method="POST" action="{{ isset($attendance) ? route('attendances.update',$attendance->id) : route('attendances.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($attendance))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <span class="required-field">*</span>
                                    <input name="date" id="date" class="datepicker form-control {{ $errors->has('date') ? ' is-invalid' : '' }}" value="{{ $attendance->date ?? old('date') }}" placeholder="Date">
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label>Employee Name</label>
                                    </div>
                                    <div class="col">
                                        <label>Status</label>
                                            <span class="required-field">*</span>
                                    </div>
                                    <div class="col">
                                        <label>Remark</label>
                                    </div>
                                </div>

                                @forelse ($employees as $employee)
                                    @isset($attendance)
                                        @php
                                            $attendanceData = $attendance->data->where('employee_id', $employee->id)->first();
                                        @endphp
                                    @endisset

                                    <div class="form-row">
                                    <div class="col-md-2 col-sm-12">
                                        {{ $employee->user->name }}
                                        <input type="hidden" value="{{ $employee->id }}" name="employees[]">
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                         <div class="form-group">
                                            <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status[]" >
                                                @foreach($attendanceOptions as $option)
                                                    <option
                                                        @if(isset($attendanceData))
                                                            {{ $attendanceData->status === $option ? 'selected' : '' }}
                                                        @endif
                                                        {{ old('status[]') ? 'selected' : '' }}
                                                        value="{{ $option }}">{{ \App\Enums\AttendanceOption::getKey($option) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <div class="form-group">
                                            <textarea class="form-control {{ $errors->has('remark') ? ' is-invalid' : '' }}" id="remark" name="remarks[]" rows="1" placeholder="Remark">{{ isset($attendanceData) ?  $attendanceData->remark  : old('remark') }}</textarea>
                                            @if ($errors->has('remarks'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('remarks') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @empty
                                    <strong>No data found.</strong>
                                @endforelse

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('attendances.index') }}" class="btn btn-danger pull-right">
                                    <i class="fas fa-chevron-circle-left"></i>
                                    <span>Back</span>
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Submit</span>
                                </button>
                            </div>
                        </for>
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
