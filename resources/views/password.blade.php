@extends('layouts.app')

@section('title','Change Password')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Change Password</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<div class="content">
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Change Password</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('users.password.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="text" class="col-4 col-form-label">Current Password <span class="text-danger">*</span></label>
                                        <div class="col-8">
                                            <input id="text" name="current_password" placeholder="Old Password" class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }}"  required="required" type="password">
                                            @if ($errors->has('current_password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('current_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text" class="col-4 col-form-label">Password <span class="text-danger">*</span></label>
                                        <div class="col-8">
                                            <input id="text" name="password" placeholder="New Password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"  required="required" type="password">
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text" class="col-4 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="col-8">
                                            <input id="text" name="password_confirmation" placeholder="Confirm Password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"  required="required" type="password">
                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            <button name="submit" type="submit" class="btn btn-primary">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

@endpush
