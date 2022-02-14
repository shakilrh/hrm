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
                    <h1>Attendances</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Attendances</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">All Attendances.</h3>
                        <div class="card-tools">
                            <!-- Button trigger report modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportModal">
                            Generate Report
                            </button>
                            @role('admin')
                            <a href="{{ route('attendances.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>
                                <span>Take Attendance</span>
                            </a>
                            @endrole
                        </div>
                    </div>

                    <!-- Report model -->
                <div class="modal fade bd-example-modal-lg" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportModalLabel">Generate Attendance Report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET" action="{{ route('attendances.report') }}" autocomplete="off">
                        <div class="modal-body">
                            <div class="row">
                                @unlessrole('employee')
                                <div class="col">
                                    <div class="form-group">
                                        <select id="employee" class="form-control select2 {{ $errors->has('employee') ? ' is-invalid' : '' }}" name="employee" required>
                                            <option selected disabled>Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option
                                                    {{ $employee->id == old('employee') ? 'selected' : '' }}
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
                                </div>
                                @endunlessrole
                                <div class="col">
                                    <div class="form-group">
                                        <input name="form" id="form" class="datepicker form-control {{ $errors->has('form') ? ' is-invalid' : '' }}" value="{{old('form') }}" placeholder=" Form" >
                                        @if ($errors->has('form'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('form') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input name="to" id="to" class="datepicker form-control {{ $errors->has('to') ? ' is-invalid' : '' }}" value="{{ old('to') }}" placeholder="To" >
                                        @if ($errors->has('to'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('to') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>


                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        {!! $dataTable->table([],true) !!}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
