@extends('layouts.app')

@section('title','Event')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($event) ? 'Edit' : 'Create New' }} Event</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Event</a></li>
                        <li class="breadcrumb-item active">{{ isset($event) ? 'Edit' : 'Create' }}</li>
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
                        <form role="form" method="POST" action="{{ isset($event) ? route('events.update',$event->id) : route('events.store') }}">
                            @csrf
                            @if (isset($event))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Event Title</label>
                                    <span class="required-field">*</span>
                                    <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ isset($event) ? $event->title : old('title') }}" placeholder="Enter Event Title">
                                     @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description" rows="5">{{ isset($event) ? $event->description : old('description') }}</textarea>
                                     @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="start">Start Date</label>
                                            <span class="required-field">*</span>
                                            <input name="start" id="start" class="datepicker form-control {{ $errors->has('start') ? ' is-invalid' : '' }}" value="{{ $event->start ?? old('start') }}" placeholder="Start Date" autocomplete="off" required>
                                            @if ($errors->has('start'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="end">End Date</label>
                                            <span class="required-field">*</span>
                                            <input name="end" id="end" class="datepicker form-control {{ $errors->has('end') ? ' is-invalid' : '' }}" value="{{ $event->end ?? old('end') }}" placeholder="End Date" autocomplete="off" required>
                                            @if ($errors->has('end'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color">Event Color</label>
                                    <span class="required-field">*</span>
                                    <input type="text" class="form-control colorpicker colorpicker-element {{ $errors->has('color') ? ' is-invalid' : '' }}" id="color" name="color" value="{{ isset($event) ? $event->color : old('color') }}" placeholder="Enter Event color" autocomplete="off">
                                     @if ($errors->has('color'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('color') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('events.index') }}" class="btn btn-danger pull-right">
                                    <i class="fas fa-chevron-circle-left"></i>
                                    <span>Back</span>
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    @if (isset($event))
                                        <i class="fas fa-sync-alt"></i>
                                        <span>Update</span>
                                    @else
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Send</span>
                                    @endif
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
