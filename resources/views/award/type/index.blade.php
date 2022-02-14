@extends('layouts.app')

@section('title','Award Type')

@push('css')

@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Award Types</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Award Types</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
         <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">All Award Types.</h3>
                            <div class="card-tools">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAwardTypeModal">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Add New Award Type</span>
                                </button>
                            </div>
                        </div>
                         <!-- Modal -->
                        <div class="modal fade" id="addAwardTypeModal" tabindex="-1" role="dialog" aria-labelledby="addAwardTypeModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAwardTypeModalLabel">Add New Award Type</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form role="form" method="POST" action="{{  route('award.types.store') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="type_name">Award Type Name </label>
                                                <span class="required-field">*</span>
                                                <span class="help">e.g. "Employee of the Year"</span>
                                                <input type="text" name="type_name" id="type_name" class="form-control {{ $errors->has('type_name') ? ' is-invalid' : '' }}"  placeholder="Enter award type name" value="{{ old('type_name') }}" required>
                                                @if ($errors->has('type_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('type_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="text-center">Awards</th>
                                        @role('admin')
                                        <th class="text-center">Timestamp</th>
                                        @endrole
                                        <th class="text-center">Action</th>
                                    </tr>
                                     @forelse($awardTypes as $key=>$awardType)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $awardType->name }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $awardType->awards->count() }}</span>
                                            </td>
                                            @role('admin')
                                            <td class="text-center">{{ $awardType->updated_at }}</td>
                                            @endrole
                                            <td class="text-center">
                                                 <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAwardType-{{ $awardType->id }}-Modal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="editAwardType-{{ $awardType->id }}-Modal" tabindex="-1" role="dialog" aria-labelledby="editAwardType-{{ $awardType->id }}-ModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editAwardType-{{ $awardType->id }}-ModalLabel">Edit Award Type</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form role="form" method="POST" action="{{  route('award.types.update',$awardType->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body text-left">
                                                                    <div class="form-group">
                                                                        <label for="type_name">Award Type Name </label>
                                                                        <span class="required-field">*</span>
                                                                        <span class="help">e.g. "Employee of the Year"</span>
                                                                        <input type="text" name="type_name" id="type_name" class="form-control {{ $errors->has('type_name') ? ' is-invalid' : '' }}"  placeholder="Enter award type name" value="{{ $awardType->name }}">
                                                                        @if ($errors->has('type_name'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('type_name') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $awardType->id }})"><i class="fas fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $awardType->id }}" action="{{ route('award.types.destroy',$awardType->id) }}" method="POST" style="display: none;">
                                                    @csrf()
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">
                                                <strong>No Data Found.</strong>
                                                <a href="#" data-toggle="modal" data-target="#addAwardTypeModal">Create the first one</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
        {{-- <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">All award Types.</h3>
                        <div class="card-tools">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addawardTypeModal">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add New award Type</span>
                            </button>
                        </div>
                    </div>


                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="datatable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                @role('admin')
                                <th>Last Modified</th>
                                @endrole
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($awardTypes as $key=>$awardType)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $awardType->name }}</td>
                                    @role('admin')
                                    <td>{{ $awardType->updated_at }}</td>
                                    @endrole
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="$"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $awardType->id }})"><i class="fas fa-trash-alt"></i></button>
                                        <form id="delete-form-{{ $awardType->id }}" action="{{ route('award-types.destroy',$awardType->id) }}" method="POST" style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
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
        </div> --}}
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
    </script>
@endpush
