<a class="btn btn-primary btn-sm" href="{{ route('branches.edit',$id) }}"><i class="fas fa-edit"></i></a>
<button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
<form id="delete-form-{{ $id }}" action="{{ route('branches.destroy',$id) }}" method="POST" style="display: none;">
    @csrf()
    @method('DELETE')
</form>
