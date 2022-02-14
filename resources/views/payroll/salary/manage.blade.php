@extends('layouts.app')

@section('title','Employees')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Salary Manager</h1>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                        <img src="{{ Storage::disk('public')->url('users/'. $employee->user->image ?? 'default.png') }}" class="img-thumbnail" alt="profile image">
                                </div>
                                <div class="col-md-5">
                                    <h4>{{$employee->user->name ?? 'Not Found' }} ({{ $employee->designation->name ?? 'Not Found' }})</h4>
                                    <strong>Email : </strong><span>{{ $employee->user->email ?? 'Not Found' }}</span><br/>
                                    <strong>Branch : </strong><span>{{ $employee->branch->name ?? 'Not Found' }}</span> <br>
                                    <strong>Department : </strong><span>{{ $employee->department->name  ?? 'Not Found' }}</span> <br>
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

                                </div>
                                <div class="col-md-5">
                                    <strong>Basic Salary ($) : </strong><span>{{ $employee->basic_salary }}</span><br/>
                                    <strong>Gross Salary ($) : </strong><span>{{ $employee->getGrossSalary() }}</span><br/>
                                    <strong>Net Salary ($) : </strong><span>{{ $employee->getNetSalary() }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
            <ul class="nav nav-tabs" id="salaryManager" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="allowance-deduction-tab" data-toggle="tab" href="#allowance-deduction" role="tab" aria-controls="allowance-deduction" aria-selected="true">Allowance & Deduction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="increment-tab" data-toggle="tab" href="#increment" role="tab" aria-controls="increment" aria-selected="false">Salary Increment</a>
                </li>
            </ul>
            <div class="tab-content" id="salaryManagerContent">
                <div class="tab-pane fade show active" id="allowance-deduction" role="tabpanel" aria-labelledby="allowance-deduction-tab">
                     <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Allowances</h3>
                                    <div class="card-tools">
                                        @unlessrole('employee')
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAllowanceModal">
                                                <i class="fas fa-plus-circle"></i>
                                                <span>Add New</span>
                                            </button>
                                        @endunlessrole
                                    </div>
                                </div>
                                @unlessrole('employee')
                                    <!-- allowance Modal -->
                                    <div class="modal fade" id="addAllowanceModal" tabindex="-1" role="dialog" aria-labelledby="addAllowanceModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAllowanceModalLabel">Add Allowance</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('payroll.salary.manager.allowance.store',$employee->employee_code) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="allowance_name">Allowance Name </label>
                                                                <span class="required-field">*</span>
                                                                <input type="text" name="allowance_name" id="allowance_name" class="form-control {{ $errors->has('allowance_name') ? ' is-invalid' : '' }}" value="{{ old('allowance_name') }}" placeholder="Enter allowance name">
                                                                @if ($errors->has('allowance_name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('allowance_name') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="allowance_amount">Allowance Amount </label>
                                                                <span class="required-field">*</span>
                                                                <input type="text" name="allowance_amount" id="allowance_amount" class="form-control {{ $errors->has('allowance_amount') ? ' is-invalid' : '' }}" value="{{ old('allowance_amount') }}" placeholder="Enter allowance amount">
                                                                @if ($errors->has('allowance_amount'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('allowance_amount') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                @endunlessrole
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            @unlessrole('employee')
                                            <th>Action</th>
                                            @endunlessrole
                                        </tr>
                                    @forelse ($employee->allowances as $key=>$allowance)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $allowance->name }}</td>
                                        <td>{{ $allowance->amount }}</td>
                                        @unlessrole('employee')
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete" onclick="deleteData('allowance-delete-form',{{ $allowance->id }})"><i class="fas fa-trash-alt"></i></button>
                                            <form id="allowance-delete-form-{{ $allowance->id }}" action="{{ route('payroll.salary.manager.allowance.destroy',['eCode'=>$employee->employee_code,'id'=>$allowance->id]) }}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        </td>
                                        @endunlessrole
                                    </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="4">
                                                <strong>No data found.</strong>
                                                @unlessrole('employee')
                                                <a href="#" data-toggle="modal" data-target="#addAllowanceModal">Create new</a>
                                                @endunlessrole
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Deductions</h3>
                                    <div class="card-tools">
                                        @unlessrole('employee')
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeductionModal">
                                            <i class="fas fa-plus-circle"></i>
                                            <span>Add New</span>
                                        </button>
                                        @endunlessrole
                                    </div>
                                </div>
                                @unlessrole('employee')
                                <!-- deduction Modal -->
                                <div class="modal fade" id="addDeductionModal" tabindex="-1" role="dialog" aria-labelledby="addDeductionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addDeductionModalLabel">Add Deduction</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('payroll.salary.manager.deduction.store',$employee->employee_code) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="deduction_name">Deduction Name </label>
                                                            <span class="required-field">*</span>
                                                            <input type="text" name="deduction_name" id="deduction_name" class="form-control {{ $errors->has('deduction_name') ? ' is-invalid' : '' }}" value="{{ old('deduction_name') }}" placeholder="Enter deduction name">
                                                            @if ($errors->has('deduction_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('deduction_name') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="deduction_amount">Deduction Amount </label>
                                                            <span class="required-field">*</span>
                                                            <input type="text" name="deduction_amount" id="deduction_amount" class="form-control {{ $errors->has('deduction_amount') ? ' is-invalid' : '' }}" value="{{ old('deduction_amount') }}" placeholder="Enter deduction amount">
                                                            @if ($errors->has('deduction_amount'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('deduction_amount') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                @endunlessrole
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover">
                                    <tbody><tr>
                                        <th>Sl.</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        @unlessrole('employee')
                                        <th>Action</th>
                                        @endunlessrole
                                    </tr>
                                    @forelse ($employee->deductions as $key=>$deduction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $deduction->name }}</td>
                                        <td>{{ $deduction->amount }}</td>
                                        @unlessrole('employee')
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete" onclick="deleteData('deduction-delete-form',{{ $deduction->id }})"><i class="fas fa-trash-alt"></i></button>
                                            <form id="deduction-delete-form-{{ $deduction->id }}" action="{{ route('payroll.salary.manager.deduction.destroy',['eCode'=>$employee->employee_code,'id'=>$deduction->id]) }}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        </td>
                                        @endunlessrole
                                    </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="4">
                                                <strong>No data found.</strong>
                                                @unlessrole('employee')
                                                <a href="#" data-toggle="modal" data-target="#addDeductionModal">Create new</a>
                                                @endunlessrole
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="increment" role="tabpanel" aria-labelledby="increment-tab">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Salary Increment</h3>
                                <div class="card-tools">
                                    @unlessrole('employee')
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addIncrementModal">
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Add New</span>
                                    </button>
                                    @endunlessrole
                                </div>
                            </div>
                            @unlessrole('employee')
                            <!-- increment Modal -->
                            <div class="modal fade" id="addIncrementModal" tabindex="-1" role="dialog" aria-labelledby="addIncrementModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addIncrementModalLabel">Salary Increment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('payroll.salary.manager.increment.store',$employee->employee_code) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="increment_amount">Increment Amount </label>
                                                <span class="required-field">*</span>
                                                <input type="text" name="increment_amount" id="increment_amount" class="form-control {{ $errors->has('increment_amount') ? ' is-invalid' : '' }}" value="{{ old('increment_amount') }}" placeholder="Enter increment amount">
                                                @if ($errors->has('increment_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('increment_amount') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="remark">Remark </label>
                                                <textarea name="remark" id="remark" class="form-control {{ $errors->has('remark') ? ' is-invalid' : '' }}">{{ old('remark') }}</textarea>
                                                @if ($errors->has('remark'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('remark') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            @endunlessrole
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Amount</th>
                                            <th>Remark</th>
                                            <th>Date</th>
                                            @unlessrole('employee')
                                            <th>Action</th>
                                            @endunlessrole
                                        </tr>
                                    </thead>
                                <tbody>

                                @forelse ($salaryIncrements as $key=>$increment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $increment->amount }}</td>
                                    <td>{{ $increment->remark }}</td>
                                    <td>{{ $increment->updated_at->toDateString() }}</td>
                                    @unlessrole('employee')
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete" onclick="deleteData('increment-delete-form',{{ $increment->id }})"><i class="fas fa-trash-alt"></i></button>
                                        <form id="increment-delete-form-{{ $increment->id }}" action="{{ route('payroll.salary.manager.increment.destroy',['eCode'=>$employee->employee_code,'id'=>$increment->id]) }}" method="POST" style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    @endunlessrole
                                </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">
                                            <strong>No data found.</strong>
                                            @unlessrole('employee')
                                            <a href="#" data-toggle="modal" data-target="#addIncrementModal">Create new</a>
                                            @endunlessrole
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready( function () {
        $('#datatable').DataTable();
    } );
    function deleteData(formId,id) {
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        });
        swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                document.getElementById(formId+'-'+id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'Your data is safe :)',
                    'info'
                )
            }
        })
    }
</script>
@endpush
