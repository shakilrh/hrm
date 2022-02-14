@extends('layouts.app')

@section('title','Award')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($award) ? 'Updated' : 'Add New' }} Award</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('awards.index') }}">Award</a></li>
                        <li class="breadcrumb-item active">{{ isset($award) ? 'Update' : 'Create' }}</li>
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
                        <form role="form" method="POST" action="{{ isset($award) ? route('awards.update',$award->id) : route('awards.store') }}">
                            @csrf
                            @if (isset($award))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                @unlessrole('employee')
                                <div class="form-group">
                                    <label for="employee">Employee</label>
                                    <span class="required-field">*</span>
                                    <select id="employee" class="form-control select2 {{ $errors->has('employee') ? ' is-invalid' : '' }}" name="employee" required>
                                        <option selected disabled>Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option
                                                @if(isset($award->employee->id))
                                                    {{ $award->employee->id === $employee->id ? 'selected' : '' }}
                                                @endif
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
                                @endunlessrole
                                <div class="form-group">
                                    <label for="award_type">Award Type</label>
                                    <span class="required-field">*</span>
                                    <select id="award_type" class="form-control select2 {{ $errors->has('award_type') ? ' is-invalid' : '' }}" name="award_type" required>
                                        <option selected disabled>Select Award Type</option>
                                        @foreach($awardTypes as $awardType)
                                            <option
                                                @if(isset($award->awardType->id))
                                                    {{ $award->awardType->id === $awardType->id ? 'selected' : '' }}
                                                @endif
                                                value="{{ $awardType->id }}">{{ $awardType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('award_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('award_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="gift_item">Gift Item </label>
                                    <span class="required-field">*</span>
                                    <input type="text" name="gift_item" id="gift_item" class="form-control {{ $errors->has('gift_item') ? ' is-invalid' : '' }}" value="{{ $award->gift_item ?? old('gift_item') }}" required>
                                    @if ($errors->has('gift_item'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('gift_item') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="cash_price">Cash Price</label>
                                    <span class="required-field">*</span>
                                    <input type="number" name="cash_price" id="cash_price" class="form-control {{ $errors->has('cash_price') ? ' is-invalid' : '' }}" value="{{ $award->cash_price ?? old('cash_price') }}" required>
                                    @if ($errors->has('cash_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cash_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <span class="required-field">*</span>
                                    <input name="date" id="date" class="datepicker form-control {{ $errors->has('date') ? ' is-invalid' : '' }}" value="{{ $award->date ?? old('date') }}" placeholder="Date" autocomplete="off" required>
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('awards.index') }}" class="btn btn-danger pull-right">
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
