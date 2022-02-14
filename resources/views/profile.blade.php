@extends('layouts.app')

@section('title','Profile')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ Storage::disk('public')->url('users/'.auth()->user()->image) }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                @foreach (auth()->user()->roles as $role)
                    <p class="text-muted text-center">{{ $role->name }}</p>
                @endforeach


                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Status</b>
                    <div class="float-right">
                        @if (auth()->user()->status === \App\Enums\UserStatus::Active)
                            <span class="badge badge-info">{{ \App\Enums\UserStatus::getKey(auth()->user()->status) }}</span>
                        @else
                            <span class="badge badge-danger">{{ \App\Enums\UserStatus::getKey(auth()->user()->status) }}</span>
                        @endif
                    </div>
                  </li>
                  <li class="list-group-item">
                    <b>Username</b> <a class="float-right">{{ auth()->user()->username }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Joined At</b> <a class="float-right">{{ auth()->user()->created_at->diffForHumans() }}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-info card-outline">
              <div class="card-body">
                  <form action="{{ route('users.profile.update') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" value="{{ auth()->user()->name }}" required>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="image">Image
                            <span class="required-field">*</span>
                            <span class="help">e.g. "Image" (png, jpg)</span>
                        </label>

                        <div class="col-sm-12">
                            <input type="file" name="image" id="image" class="dropify {{ $errors->has('image') ? ' is-invalid' : '' }}">
                            @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-info">Update</button>
                        </div>
                      </div>
                    </form>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@push('js')

@endpush
