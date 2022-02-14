<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ settings('application_name') }} | Attendance Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
   <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                                <img src="{{ Storage::disk('public')->url('users/'.$employee->user->image) }}" class="img-thumbnail" alt="profile image">
                        </div>
                        <div class="col-md-4">
                            <h4>{{ $employee->user->name }} ({{ $employee->designation->name }})</h4>
                            <strong>Email : </strong><span>{{ $employee->user->email }}</span><br/>
                            <strong>Branch : </strong><span>{{ $employee->branch->name }}</span> <br>
                            <strong>Department : </strong><span>{{ $employee->department->name }}</span> <br>
                            <strong>Status : </strong>
                            @if ($employee->user->status == \App\Enums\UserStatus::Active)
                                {{ \App\Enums\UserStatus::getKey($employee->user->status) }}
                            @else
                                {{ \App\Enums\UserStatus::getKey($employee->user->status) }}
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
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Instant Deduction</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Deduction Amount:</strong>
                                    <div class="float-right">
                                        <span>$ {{ $payslip->instant_deduction }}</span>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Deduction Reason:</strong>
                                    <p>{{ $payslip->deduction_reason }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payment Details.</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Net Salary:</strong>
                                    <div class="float-right">
                                        <span>$</span>
                                        <span id="net_salary">{{ $payslip->getNetSalary() }}</span>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Status:</strong>
                                    <div class="float-right">
                                        @if ($payslip->status == \App\Enums\PayslipStatus::Paid)
                                            {{ \App\Enums\PayslipStatus::getKey($payslip->status) }}
                                        @else
                                            {{ \App\Enums\PayslipStatus::getKey($payslip->status) }}
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
