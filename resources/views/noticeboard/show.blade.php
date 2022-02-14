@extends('layouts.app')

@section('title')
{{ $notice->title }}
@endsection

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('noticeboard.index') }}">Notice</a></li>
                        <li class="breadcrumb-item active">Show</li>
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
                        <div class="card-header">
                            <h3 class="card-title">{{ $notice->title }}</h3>
                            @role('admin')
                                <small>Send At : {{ $notice->updated_at }}</small>
                                @if ($notice->status == \App\Enums\NoticeStatus::Published)
                                    <span class="badge badge-primary">{{ \App\Enums\NoticeStatus::getKey($notice->status) }}</span>
                                @else
                                    <span class="badge badge-danger">{{ \App\Enums\NoticeStatus::getKey($notice->status) }}</span>
                                @endif
                            @else
                                <small>Received At : {{ $notice->updated_at->diffForHumans() }}</small>
                            @endrole
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! $notice->description !!}
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('noticeboard.index') }}" class="btn btn-danger pull-right">
                                <i class="fas fa-chevron-circle-left"></i>
                                <span>Back</span>
                            </a>
                        </div>
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
