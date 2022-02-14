@extends('layouts.app')

@section('title','Designations')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($designation) ? 'Edit' : 'Add New' }} Designation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('designations.index') }}">Designation</a></li>
                        <li class="breadcrumb-item active">{{ isset($designation) ? 'Edit' : 'Create' }}</li>
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
                        <designation-form
                            :departments="{{ json_encode($departments->toArray()) }}"
                            :current-department="{{ isset($designation->department) ? json_encode($designation->department) : json_encode(null) }}"
                            :designation="{{ isset($designation) ? json_encode($designation->toArray()) : json_encode(null)}}"
                            :action="{{ isset($designation) ? json_encode(route('designations.update',$designation->id)) : json_encode(route('designations.store')) }}"
                            :back-url="{{ json_encode(route('designations.index')) }}">
                        </designation-form>
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
