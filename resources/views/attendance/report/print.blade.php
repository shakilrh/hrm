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
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
            <i class="fa fa-globe"></i> {{ settings('application_name') }}
            <small class="float-right">Date: {{ \Carbon\Carbon::now()->toDateString() }}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
            <strong>{{ settings('application_name') }}</strong><br>
            {{ settings('address') }}<br>
            Email: {{ settings('system_email') }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
            <strong>{{ $employee->user->name }}</strong><br>
            {{ $employee->present_address }}
            Phone:{{ $employee->phone }}<br>
            Email: {{ $employee->user->email }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Form:</b> {{ request()->form }}<br>
            <b>TO:</b> {{ request()->to }}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

     <!-- Table row -->
    <div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Status</th>
            <th>Remark</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($attendanceData as $key=>$data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->attendance->date }}</td>
                    <td>
                        @if ($data->status == \App\Enums\AttendanceOption::Present)
                            {{ \App\Enums\AttendanceOption::getKey($data->status) }}
                        @elseif($data->status == \App\Enums\AttendanceOption::Absence)
                            {{ \App\Enums\AttendanceOption::getKey($data->status) }}
                        @else
                           {{ \App\Enums\AttendanceOption::getKey($data->status) }}
                        @endif

                    </td>
                    <td>{{ $data->remark }}</td>
                </tr>
            @empty

            @endforelse

        </tbody>
        </table>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
    <!-- accepted payments column -->
    <div class="col-6">
    </div>
    <!-- /.col -->
    <div class="col-6">
    <p class="lead">Attendances Statistics</p>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th>Present</th>
                <td>{{ $totalPresent }}</td>
            </tr>
                <tr>
                <th>Absence</th>
                <td>{{ $totalAbsence }}</td>
            </tr>
                <tr>
                <th>Leave</th>
                <td>{{ $totalLeave }}</td>
            </tr>
            <tr>
                <th style="width:50%">Total Days:</th>
                <td>{{ $totalDays }}</td>
            </tr>
        </tbody>
    </table>
        </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
