@extends('layouts.app')

@section('title','Branch')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($branch) ? 'Edit' : 'Add New' }} Branch</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Branch</a></li>
                        <li class="breadcrumb-item active">{{ isset($user) ? 'Update' : 'Create' }}</li>
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
                        <branch-form
                            :branch="{{ isset($branch) ? json_encode($branch->toArray()) : json_encode(null)}}"
                            :action="{{ isset($branch) ? json_encode(route('branches.update',$branch->id)) : json_encode(route('branches.store')) }}"
                            :url="{{ json_encode(route('branches.index')) }}">
                        </branch-form>
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
