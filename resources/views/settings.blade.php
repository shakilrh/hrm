@extends('layouts.app')

@section('title','Settings')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <!-- form start -->
                        <form autocomplete="off" role="form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="application_name">Application Name</label>
                                    <input name="application_name" id="application_name" class="form-control {{ $errors->has('application_name') ? ' is-invalid' : '' }}" value="{{ settings('application_name') ?? old('application_name') }}" placeholder="Application Name">
                                    @if ($errors->has('application_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('application_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="application_title">Application Title</label>
                                    <input name="application_title" id="application_title" class="form-control {{ $errors->has('application_title') ? ' is-invalid' : '' }}" value="{{ settings('application_title') ?? old('application_title') }}" placeholder="Application Title">
                                    @if ($errors->has('application_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('application_title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                 <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}">{{ settings('address') ?? old('address') }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="system_email">System Email</label>
                                    <input name="system_email" id="system_email" class="form-control {{ $errors->has('system_email') ? ' is-invalid' : '' }}" value="{{ settings('system_email') ?? old('system_email') }}" placeholder="System Email">
                                    @if ($errors->has('system_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('system_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="logo">Logo </label>
                                            <span class="help">Size:100x100 (Image will be auto resize.)</span>
                                            <input type="file" name="logo" id="logo" class="dropify {{ $errors->has('logo') ? ' is-invalid' : '' }}" data-default-file="{{ Storage::disk('public')->url(settings('logo')) }}">
                                            @if ($errors->has('logo'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('logo') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="favicon">Favicon </label>
                                            <span class="help">Size:34x34 (Image will be auto resize.)</span>
                                            <input type="file" name="favicon" id="favicon" class="dropify {{ $errors->has('favicon') ? ' is-invalid' : '' }}" data-default-file="{{ Storage::disk('public')->url(settings('favicon')) }}">
                                            @if ($errors->has('favicon'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('favicon') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    <span>Save Changes</span>
                                </button>
                            </div>
                        </for>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('js')

@endpush
