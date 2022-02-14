@extends('layouts.app')

@section('title','Notifications')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">All Notifications</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">notifications</li>
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
                    <div class="card card-primary card-outline p-2">
                        <ul class="timeline timeline-inverse">
                            <!-- timeline item -->
                            @if (auth()->user()->notifications->count() > 0)
                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        <span class="badge badge-danger">New</span>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $notification->created_at->diffForHumans() }}</span>

                                            <h3 class="timeline-header"><a href="{{ $notification->data['action'] }}" class="text-decoration-none">{{ $notification->data['title'] }}</a></h3>
                                        </div>
                                    </li>
                                @endforeach

                                @foreach (auth()->user()->readNotifications as $notification)
                                    <li>
                                        <i class="fa fa-envelope bg-primary"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $notification->created_at->diffForHumans() }}</span>

                                            <h3 class="timeline-header"><a href="{{ $notification->data['action'] }}" class="text-decoration-none">{{ $notification->data['title'] }}</a></h3>

                                        </div>
                                    </li>
                                @endforeach
                            @else
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                                <div class="timeline-item p-2 text-center">
                                    <h3 class="timeline-body"><i class="far fa-bell-slash"></i> All caught up!</h3>
                                </div>
                            </li>
                            @endif

                            <!-- END timeline item -->
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <a href="{{ route('notifications.mark-as-read') }}" class="btn btn-primary btn-sm">Mark All As Read</a>
                                    <a href="{{ route('notifications.destroy') }}" class="btn btn-danger btn-sm">Clear All</a>
                                </div>
                            </div>
                        </div>

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
