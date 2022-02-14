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
                    <h1>Payslips</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('payroll.payslips.index') }}">Payslips</a></li>
                        <li class="breadcrumb-item active">{{ isset($payslip) ? 'Edit' : 'Create' }}</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                        <img src="{{ Storage::disk('public')->url('users/'.$employee->user->image) }}" class="img-thumbnail" alt="profile image">
                                </div>
                                <div class="col-md-4">
                                    <h4>{{ $employee->user->name ?? 'Not Found' }} ({{ $employee->designation->name ?? 'Not Found' }})</h4>
                                    <strong>Email : </strong><span>{{ $employee->user->email ?? 'Not Found' }}</span><br/>
                                    <strong>Branch : </strong><span>{{ $employee->branch->name ?? 'Not Found' }}</span> <br>
                                    <strong>Department : </strong><span>{{ $employee->department->name ?? 'Not Found' }}</span> <br>
                                    <strong>Status : </strong>
                                    @if (isset($employee->user->status))
                                        @if ($employee->user->status == \App\Enums\UserStatus::Active)
                                            <span class="badge badge-primary">
                                                {{ \App\Enums\UserStatus::getKey($employee->user->status) }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                {{ \App\Enums\UserStatus::getKey($employee->user->status) }}
                                            </span>
                                        @endif
                                    @else
                                        <strong>Not Found</strong>
                                    @endif

                                    <h5 class="text-muted">Salary Month: {{ \App\Enums\Month::getKey(isset($payslip) ? (int)$payslip->month : $month) }}, {{ isset($payslip) ? $payslip->year : $year }}</h5>
                                </div>
                                <div class="col-md-3">
                                    <strong>Basic Salary: </strong>
                                    <span class="float-right">$ {{ $employee->basic_salary }}</span><br/>
                                    <strong>Total Allowance:</strong>
                                    <span class="float-right">$ {{ $employee->getTotalAllowances() }}</span><br>
                                    <strong>Total Deduction:</strong>
                                    <span class="float-right">$ {{ $employee->getTotalDeductions() }}</span><br>
                                    <strong>Total Salary:</strong>
                                    <span class="float-right">$ {{ $employee->getNetSalary() }}</span><br>
                                    <input type="hidden" id="total_salary" value="{{ $employee->getNetSalary() }}">
                                </div>
                                <div class="col-md-3">
                                    <strong>Present:</strong>
                                            <span class="float-right">{{ $totalPresent }}</span> <br/>
                                    <strong>Absence:</strong>
                                            <span class="float-right">{{ $totalAbsence }}</span> <br/>
                                     <strong>Leave:</strong>
                                            <span class="float-right">{{ $totalLeave }}</span> <br/>
                                    <strong>Total Working Days:</strong>
                                            <span class="float-right">{{ $totalDays }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
            <form method="POST" action="{{ isset($payslip) ? route('payroll.payslips.update',$payslip->id) : route('payroll.payslips.store') }}" autocomplete="off">
                @csrf
                @isset($payslip)
                    @method('PUT')
                @endisset
                <input type="hidden" name="employee" value="{{ $employee->id }}">
                <input type="hidden" name="month" value="{{ isset($payslip) ? $payslip->month : $month }}">
                <input type="hidden" name="year" value="{{ isset($payslip) ? $payslip->year : $year }}">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h4 class="card-title">Instant Deduction</h4>
                            </div>
                            <div class="card-body ">
                                <div class="form-group">
                                    <input type="number" onkeyup="calculate()" class="form-control {{ $errors->has('deduction_amount') ? ' is-invalid' : '' }}" id="deduction_amount" name="deduction_amount" placeholder="Deduction Amount" value="{{ isset($payslip) ? $payslip->instant_deduction : old('deduction_amount') }}" >
                                        @if ($errors->has('deduction_amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('deduction_amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control {{ $errors->has('deduction_reason') ? ' is-invalid' : '' }}" id="deduction_reason" name="deduction_reason" rows="3" placeholder="Deduction Reason">{{ isset($payslip) ? $payslip->deduction_reason : old('deduction_reason') }}</textarea>
                                        @if ($errors->has('deduction_reason'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('deduction_reason') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h4 class="card-title">Payment Details.</h4>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>Net Salary:</strong>
                                                <div class="float-right">
                                                    <span>$</span>
                                                    <span id="net_salary">{{ $employee->getNetSalary() }}</span>
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group p-4">
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" data-placeholder="Payslip Status" >
                                                <option></option>
                                                @foreach($payslipStatus as $status)
                                                    <option
                                                        @if(isset($payslip))
                                                        {{ $payslip->status === $status ? 'selected' : '' }}
                                                        @endif
                                                        @if(old('status'))
                                                            {{ old('status') == $status ? 'selected' : '' }}
                                                        @endif
                                                        value="{{ $status }}">{{ \App\Enums\PayslipStatus::getKey($status) }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('payroll.payslips.index') }}" class="btn btn-danger pull-right">
                                    <i class="fas fa-chevron-circle-left"></i>
                                    <span>Back</span>
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Submit</span>
                                </button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </form>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
<script>
    calculate()
    function calculate() {
        let amount = document.getElementById("deduction_amount").value;
        let total = document.getElementById("total_salary").value;
        let net = total - amount;
        document.getElementById("net_salary").textContent=net;
    }
</script>
@endpush
