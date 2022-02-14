@extends('layouts.app')

@section('title','User')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
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
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($user) ? 'Updated User' : 'Add New User' }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form user="form" method="POST" action="{{ isset($user) ? route('users.update',$user->id) : route('users.store') }}">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" value="{{ isset($user) ? $user->name : old('name') }}" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="username">@Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter @username" value="{{ isset($user) ? $user->username : old('username') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ isset($user) ? $user->email : old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="******" {{ isset($user) ? '' : 'required' }}>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******" {{ isset($user) ? '' : 'required' }}>
                                </div>
                                <div class="form-group">
                                    <label for="role">Select Role</label>
                                    <select id="role" class="form-control select2" name="role" data-placeholder="Role" required>
                                        @foreach($roles as $key=>$role)
                                            @if ($role->name != 'employee')
                                                <option
                                                    @if(isset($user))
                                                        @foreach($user->roles as $userRole)
                                                        {{ $role->id == $userRole->id ? 'selected' : '' }}
                                                        @endforeach
                                                    @endif
                                                    value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">User Status</label>
                                    <select id="status" class="form-control select2" name="status" >
                                        <option selected disabled>Select Status</option>
                                        @foreach($userStatus as $status)
                                            <option
                                                @if(isset($user))
                                                    {{ $user->status === $status ? 'selected' : '' }}
                                                @endif
                                                value="{{ $status }}">{{ \App\Enums\UserStatus::getKey($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="{{ route('users.index') }}" class="btn btn-danger pull-right">
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
