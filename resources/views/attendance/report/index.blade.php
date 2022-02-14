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
                    <h1>Attendances Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Attendances Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
            <div class="invoice p-3 mb-3">
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
                                        <span class="badge badge-primary">{{ \App\Enums\AttendanceOption::getKey($data->status) }}</span>
                                    @elseif($data->status == \App\Enums\AttendanceOption::Absence)
                                        <span class="badge badge-danger">{{ \App\Enums\AttendanceOption::getKey($data->status) }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ \App\Enums\AttendanceOption::getKey($data->status) }}</span>
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
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a
                  @role('employee')
                     href="{{ route('attendances.print').'?form='.request('form').'&to='.request('to').'' }}"
                  @else
                     href="{{ route('attendances.print').'?employee='.request('employee').'&form='.request('form').'&to='.request('to').'' }}"
                  @endrole
                  target="_blank"
                  class="btn btn-primary float-right" style="margin-right: 5px;">
                   <i class="fa fa-print"></i>
                   <span>Print</span>
                  </a>
                </div>
              </div>
            </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('js')

@endpush
