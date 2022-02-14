{{-- <div class="progress progress-sm active">
    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
    <span class="sr-only">20% Complete</span>
    </div>
</div> --}}
<a class="btn btn-primary btn-sm" href="{{ route('attendances.edit',$id) }}"><i class="fas fa-edit"></i></a>
<button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
<form id="delete-form-{{ $id }}" action="{{ route('attendances.destroy',$id) }}" method="POST" style="display: none;">
    @csrf()
    @method('DELETE')
</form>

