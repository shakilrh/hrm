@role('admin')
<a class="btn btn-primary btn-sm" data-placement="top" title="Edit Event" href="{{ route('events.edit',$id) }}"><i class="fas fa-edit"></i></a>

<button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete Event" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
<form id="delete-form-{{ $id }}" action="{{ route('events.destroy',$id) }}" method="POST" style="display: none;">
    @csrf()
    @method('DELETE')
</form>
@endrole
