@extends('layouts.app')

@section('title','Department')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($department) ? 'Edit ' : 'Add New ' }} Department</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Department</a></li>
                        <li class="breadcrumb-item active">{{ isset($department) ? 'Edit' : 'Create' }}</li>
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
                        <!-- /.card-header -->
                        <!-- form start -->
                        <department-form
                            :users="{{ json_encode($users) }}"
                            :current-dept-head="{{ isset($department->user) ? json_encode($department->user) : json_encode(null) }}"
                            :department="{{ isset($department) ? json_encode($department->toArray()) : json_encode(null)}}"
                            :action="{{ isset($department) ? json_encode(route('departments.update',$department->id)) : json_encode(route('departments.store')) }}"
                            :url="{{ json_encode(route('departments.index')) }}">

                        </department-form>
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
