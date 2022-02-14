@role('admin')
<a class="btn btn-primary btn-sm" data-placement="top" title="Edit Notice" href="{{ route('noticeboard.edit',$id) }}"><i class="fas fa-edit"></i></a>
@endrole

<a class="btn btn-info btn-sm" data-placement="top" title="Show Notice" href="{{ route('noticeboard.show',$id) }}">View</i></a>

@role('admin')
<button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete Notice" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
<form id="delete-form-{{ $id }}" action="{{ route('noticeboard.destroy',$id) }}" method="POST" style="display: none;">
    @csrf()
    @method('DELETE')
</form>
@endrole
