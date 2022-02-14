@extends('layouts.app')

@section('title','Notice')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($notice) ? 'Edit' : 'Send New' }} Notice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('noticeboard.index') }}">Notice</a></li>
                        <li class="breadcrumb-item active">{{ isset($notice) ? 'Edit' : 'Create' }}</li>
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
                        <form role="form" method="POST" action="{{ isset($notice) ? route('noticeboard.update',$notice->id) : route('noticeboard.store') }}">
                            @csrf
                            @if (isset($notice))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="notice_title">Notice Title</label>
                                    <input type="text" class="form-control {{ $errors->has('notice_title') ? ' is-invalid' : '' }}" id="notice_title" name="notice_title" value="{{ isset($notice) ? $notice->title : old('notice_title') }}" placeholder="Enter Notice Title">
                                     @if ($errors->has('notice_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('notice_title') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="status">Notice Status</label>
                                    <span class="required-field">*</span>
                                    <select id="status" class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" required>
                                        <option selected disabled>Select Status</option>
                                        @foreach($noticeStatus as $status)
                                            <option
                                                @if(isset($notice))
                                                    {{ $notice->status === $status ? 'selected' : '' }}
                                                @endif
                                                value="{{ $status }}">{{ \App\Enums\NoticeStatus::getKey($status) }}</option>
                                        @endforeach
                                    </select>
                                     @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="summernote form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description" rows="5">{{ isset($notice) ? $notice->description : old('description') }}</textarea>
                                     @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('noticeboard.index') }}" class="btn btn-danger pull-right">
                                    <i class="fas fa-chevron-circle-left"></i>
                                    <span>Back</span>
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    @if (isset($notice))
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
