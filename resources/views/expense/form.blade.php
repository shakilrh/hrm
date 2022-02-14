@extends('layouts.app')

@section('title','Expense')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($expense) ? 'Updated' : 'Add New' }} Expense</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expense</a></li>
                        <li class="breadcrumb-item active">{{ isset($expense) ? 'Update' : 'Create' }}</li>
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
                        <form role="form" method="POST" action="{{ isset($expense) ? route('expenses.update',$expense->id) : route('expenses.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($expense))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="item_name">Item Name</label>
                                    <span class="required-field">*</span>
                                    <input type="text" class="form-control {{ $errors->has('item_name') ? ' is-invalid' : '' }}" id="item_name" name="item_name" placeholder="Enter item name" value="{{ isset($expense) ? $expense->item_name : old('item_name') }}" required autofocus>
                                     @if ($errors->has('item_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('item_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="purchase_from">Purchase From</label>
                                    <span class="required-field">*</span>
                                    <input type="text" class="form-control {{ $errors->has('purchase_from') ? ' is-invalid' : '' }}" id="purchase_from" name="purchase_from" value="{{ isset($expense) ? $expense->purchase_from : old('purchase_from') }}" required>
                                     @if ($errors->has('purchase_from'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('purchase_from') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @unlessrole('employee')
                                <div class="form-group">
                                    <label for="purchase_by">Purchase By</label>
                                    <span class="required-field">*</span>
                                    <select id="purchase_by" class="form-control select2 {{ $errors->has('purchase_by') ? ' is-invalid' : '' }}" name="purchase_by" required>
                                        <option selected disabled>Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option
                                                @if(isset($expense->employee))
                                                    {{ $expense->employee->id === $employee->id ? 'selected' : ''  }}
                                                @endif
                                                value="{{ $employee->id }}">{{ $employee->user->name }} ({{ $employee->employee_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('purchase_by'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('purchase_by') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @endunlessrole
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <span class="required-field">*</span>
                                    <input name="purchase_date" id="purchase_date" class="datepicker form-control {{ $errors->has('purchase_date') ? ' is-invalid' : '' }}" value="{{ $expense->purchase_date ?? old('purchase_date') }}" placeholder="Purchase Date" autocomplete="off" required>
                                    @if ($errors->has('purchase_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('purchase_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <span class="required-field">*</span>
                                    <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="amount" name="amount" placeholder="Enter amount" value="{{ isset($expense) ? $expense->amount : old('amount') }}" required>
                                     @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                @unlessrole('employee')
                                <div class="form-group">
                                    <label for="status">Expense Status</label>
                                    <span class="required-field">*</span>
                                    <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" required>
                                        <option selected disabled>Select Status</option>
                                        @foreach($expenseStatus as $status)
                                            <option
                                                @if(isset($expense))
                                                    {{ $expense->status === $status ? 'selected' : '' }}
                                                @endif
                                                value="{{ $status }}">{{ \App\Enums\ExpenseStatus::getKey($status) }}</option>
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
                                    <label for="bill_copy">Upload Bill Copy </label>
                                    <span class="help">e.g. "bill or invoice copy"</span>
                                    <input type="file" name="bill_copy" id="bill_copy" class="dropify {{ $errors->has('bill_copy') ? ' is-invalid' : '' }}"
                                    @isset($expense)
                                        @if ($expense->bill_copy != null)
                                            data-default-file="{{ Storage::disk('public')->url('expense/'.$expense->bill_copy) }}"
                                        @endif
                                    @endisset
                                    >
                                    @if ($errors->has('bill_copy'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill_copy') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="{{ route('expenses.index') }}" class="btn btn-danger pull-right">
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
