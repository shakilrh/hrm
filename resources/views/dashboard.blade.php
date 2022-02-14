@extends('layouts.app')

@section('title','Dashboard')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        @unlessrole('employee')
                            <div class="inner">
                                <h3>{{ $employeesCount }}</h3>
                                <p>Total <br> <strong>Employees</strong></p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <a href="{{ route('employees.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        @else
                            <div class="inner">
                                <h3>{{ $awardsCount }}</h3>
                                <p>This Month <br> <strong>Awards</strong></p>
                            </div>
                            <div class="icon">
                               <i class="fas fa-award"></i>
                            </div>
                            <a href="{{ route('employees.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        @endunlessrole
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $leaveApplicationCount }}</h3>
                        <p>This Month <br> <strong>Leave Application</strong></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-poll-h"></i>
                    </div>
                    <a href="{{ route('leave.applications.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $expenseCount }}</h3>
                        <p>This Month <br> <strong>Expense Request</strong></p>
                    </div>
                    <div class="icon">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <a href="{{ route('expenses.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                    <div class="inner">
                       <h3>{{ $eventsCount }}</h3>
                       <p>This Month <br> <strong>Events & Holidays</strong></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <a href="{{ Auth::user()->hasRole('employee') ? route('events.calendar') : route('events.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        @unlessrole('employee')
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-code-branch"></i>
                        </span>

                        <div class="info-box-content">
                            <a href="{{ route('branches.index') }}" class="text-decoration-none text-dark">
                                <span class="info-box-text">Branches</span>
                            </a>
                            <span class="info-box-number">{{ $branchesCount }}</span>
                        </div>
                        @else
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-calendar-day"></i>
                        </span>

                        <div class="info-box-content">
                            <a href="{{ route('branches.index') }}" class="text-decoration-none text-dark">
                                <span class="info-box-text">This Month</span>
                                <span class="info-box-text">Total Working Day</span>
                            </a>
                            <span class="info-box-number">{{ $totalDays }}</span>
                        </div>
                        @endunlessrole
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        @unlessrole('employee')
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-project-diagram"></i>
                            </span>

                            <div class="info-box-content">
                                <a href="{{ route('departments.index') }}" class="text-decoration-none text-dark">
                                    <span class="info-box-text">Departments</span>
                                </a>
                                <span class="info-box-number">{{ $departmentsCount }}</span>
                            </div>
                        @else
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-user-check"></i>
                            </span>

                            <div class="info-box-content">
                                <a href="{{ route('departments.index') }}" class="text-decoration-none text-dark">
                                    <span class="info-box-text">This Month</span>
                                    <span class="info-box-text">Total Present Day</span>
                                </a>
                                <span class="info-box-number">{{ $totalPresent }}</span>
                            </div>
                        @endunlessrole

                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        @unlessrole('employee')
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-sticky-note"></i>
                            </span>

                            <div class="info-box-content">
                            <a href="{{ route('noticeboard.index') }}" class="text-decoration-none text-dark">
                                    <span class="info-box-text">This Month Notice</span>
                                </a>
                                <span class="info-box-number">{{ $noticeCount }}</span>
                            </div>
                        @else
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-user-times"></i>
                            </span>

                            <div class="info-box-content">
                            <a href="{{ route('noticeboard.index') }}" class="text-decoration-none text-dark">
                                    <span class="info-box-text">This Month</span>
                                    <span class="info-box-text">Total Absence</span>
                                </a>
                                <span class="info-box-number">{{ $totalAbsence }}</span>
                            </div>
                        @endunlessrole

                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        @unlessrole('employee')
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-award"></i>
                            </span>

                            <div class="info-box-content">
                                <a href="{{ route('awards.index') }}" class="text-decoration-none text-dark">
                                    <span class="info-box-text">This Month Awards</span>
                                </a>
                                <span class="info-box-number">{{ $awardsCount }}</span>
                            </div>
                        @else
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-user-slash"></i>
                            </span>

                            <div class="info-box-content">
                                <a href="{{ route('awards.index') }}" class="text-decoration-none text-dark">
                                    <span class="info-box-text">This Month</span>
                                    <span class="info-box-text">Total Leave</span>
                                </a>
                                <span class="info-box-number">{{ $totalLeave }}</span>
                            </div>
                        @endunlessrole

                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <div class="d-flex justify-content-between">
                            <h3 class="card-title">Expenses analytics</h3>
                            </div>
                        </div>
                        <div class="card-body" id="expense-chart">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Recent Leave Application</h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Received At</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentLeaveApplications as $key=>$leaveApplication)
                                    <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $leaveApplication->employee->user->name ?? 'Not Found'}}</td>
                                    <td>{{ $leaveApplication->type->name ?? 'Not Found' }}</td>
                                    <td>
                                        @if ($leaveApplication->status == \App\Enums\LeaveStatus::Approved)
                                            <span class="badge badge-primary">
                                                {{  \App\Enums\LeaveStatus::getKey($leaveApplication->status) }}
                                            </span>

                                        @else
                                                <span class="badge badge-danger">
                                                {{  \App\Enums\LeaveStatus::getKey($leaveApplication->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $leaveApplication->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5"><strong>No Data found.</strong></td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('leave.applications.create') }}" class="btn btn-sm btn-info float-left">Create New</a>
                            <a href="{{ route('leave.applications.index') }}" class="btn btn-sm btn-secondary float-right">View All Applications</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Recent Expense Request</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Purchase By</th>
                        <th>Amount</th>
                        {{-- <th>Date</th> --}}
                        <th>Status</th>
                        <th>Received At</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentExpenseRequests as $key=>$expenseRequest)
                            <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $expenseRequest->employee->user->name ?? 'Not Found' }}</td>
                            <td>{{ $expenseRequest->amount }}</td>
                            {{-- <td>{{ $expenseRequest->purchase_date }}</td> --}}
                            <td>
                                @if ($expenseRequest->status == \App\Enums\ExpenseStatus::Approved)
                                    <span class="badge badge-primary">
                                        {{  \App\Enums\ExpenseStatus::getKey($expenseRequest->status) }}
                                    </span>

                                @else
                                        <span class="badge badge-danger">
                                        {{  \App\Enums\ExpenseStatus::getKey($expenseRequest->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $expenseRequest->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5"><strong>No Data found.</strong></td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-info float-left">Add New Expense</a>
                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-secondary float-right">View All Expenses</a>
              </div>
              <!-- /.card-footer -->
            </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script>
Highcharts.chart('expense-chart', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Monthly Expenses'
    },
    xAxis: {
        categories: [
            @foreach($expenses as $expense)
            // 'Jan',
            '{{ \App\Enums\Month::getKey((int)$expense->month) }}-{{ $expense->year }}',
            @endforeach
        ]
    },
    yAxis: {
        title: {
            text: 'Expense Amount'
        },
        labels: {
            formatter: function () {
                return this.value + '$';
            }
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Expense',
        marker: {
            symbol: 'round'
        },
        data: [
            @foreach($expenses as $expense)
            {{ $expense->total_expense }},
            @endforeach
        ]

    }]
});
</script>

@endpush
