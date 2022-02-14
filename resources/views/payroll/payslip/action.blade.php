<a class="btn btn-primary btn-sm" data-placement="top" title="Edit" href="{{ route('payroll.payslips.edit',$id) }}"><i class="fas fa-edit"></i></a>

<a class="btn btn-info btn-sm" data-placement="top" title="Show" href="{{ route('payroll.payslips.show',$id) }}">View</i></a>

<button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
<form id="delete-form-{{ $id }}" action="{{ route('payroll.payslips.destroy',$id) }}" method="POST" style="display: none;">
    @csrf()
    @method('DELETE')
</form>
