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
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">All Users.</h3>
                        <div class="card-tools">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>
                                <span>Create New</span>
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="datatable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th class="text-center">Status</th>
                                @role('admin')
                                <th>Last Modified</th>
                                @endrole
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key=>$user)
                                @if (!$user->hasRole('employee'))
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td style="width: 20%">
                                            @forelse($user->roles as $key=>$role)
                                                <span class="badge badge-info">{{ $role->name }}</span>
                                            @empty
                                                <span class="badge badge-danger">No permission found :(</span>
                                            @endforelse
                                        </td>
                                        <td style="width: 20%" class="text-center">
                                            @if ($user->status === \App\Enums\UserStatus::Active)
                                                <span class="badge badge-info">{{ \App\Enums\UserStatus::getKey($user->status) }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ \App\Enums\UserStatus::getKey($user->status) }}</span>
                                            @endif
                                        </td>
                                        @role('admin')
                                        <td>{{ $user->updated_at }}</td>
                                        @endrole
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $user->id }})"><i class="fas fa-trash-alt"></i></button>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy',$user->id) }}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Permissions</th>
                                <th class="text-center">Status</th>
                                @role('admin')
                                <th>Last Modified</th>
                                @endrole
                                <th class="text-center">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $("#datatable").DataTable();
        });
        function deleteData(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });
            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                    swalWithBootstrapButtons(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'info'
                    )
                }
            })
        }
    </script>
@endpush
