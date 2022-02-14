<a class="btn btn-primary btn-sm" data-placement="top" title="Edit Award" href="{{ route('awards.edit',$id) }}"><i class="fas fa-edit"></i></a>
<button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete Award" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
<form id="delete-form-{{ $id }}" action="{{ route('awards.destroy',$id) }}" method="POST" style="display: none;">
    @csrf()
    @method('DELETE')
</form>
