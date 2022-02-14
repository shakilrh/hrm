@extends('layouts.app')

@section('title','Employee')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payslips</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Payslips</li>
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
                        <h3 class="card-title">Payment History.</h3>
                        <div class="card-tools">
                            @unlessrole('employee')
                            <a href="{{ route('payroll.payslips.create') }}" class="btn btn-primary" data-toggle="modal" data-target="#payslipModal">
                                <i class="fas fa-plus-circle"></i>
                                <span>Make Payment</span>
                            </a>
                            @endunlessrole
                        </div>
                    </div>
                    @unlessrole('employee')
                    <!-- payslip model -->
                    <div class="modal fade" id="payslipModal" tabindex="-1" role="dialog" aria-labelledby="payslipModalLabel" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="payslipModalLabel">Make Payment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="GET" action="{{ route('payroll.payslips.create') }}" autocomplete="off">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee">Select Employee</label>
                                            <select id="employee" class="form-control select2{{ $errors->has('employee') ? ' is-invalid' : '' }}" name="employee" style="width:200px" required >
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="year">Select Year</label>
                                            <select id="year" class="form-control select2{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" style="width:100px" required >
                                                <option selected disabled>Select Year</option>
                                                @for ($year = 1900; $year <= now()->year; $year++)
                                                    <option
                                                        {{ $year == now()->year ? 'selected' : '' }}
                                                    value="{{ $year }}">
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('year'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('year') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="month">Select Month</label>
                                            <select id="month" class="form-control select2{{ $errors->has('month') ? ' is-invalid' : '' }}" name="month" style="width:100px" required >
                                                <option selected disabled>Month</option>
                                                @foreach($months as $month)
                                                    <option
                                                        @if(old('month'))
                                                        {{ old('month') == $month ? 'selected' : '' }}
                                                        @endif
                                                        value="{{ $month }}">{{ \App\Enums\Month::getKey($month) }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('month'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('month') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    @endunlessrole
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        @unlessrole('employee')
                            {!! $dataTable->table([],true) !!}
                        @else
                            <table id="datatable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Net Salary</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($payslips as $key=>$payslip)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ \App\Enums\Month::getKey((int)$payslip->month) }}
                                        </td>
                                        <td>{{ $payslip->year }}</td>
                                        <td>{{ $payslip->getNetSalary() }}</td>
                                        <td>
                                            @if ($payslip->status == \App\Enums\PayslipStatus::Paid)
                                                <span class="badge badge-primary">{{ \App\Enums\PayslipStatus::getKey($payslip->status) }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ \App\Enums\PayslipStatus::getKey($payslip->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $payslip->updated_at->toDateString() }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm" data-placement="top" title="Show" href="{{ route('payroll.payslips.show',$payslip->id) }}">View</i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Net Salary</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        @endunlessrole
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
    @unlessrole ('employee')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
        {!! $dataTable->scripts() !!}
    @else
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @endunlessrole
@endpush
