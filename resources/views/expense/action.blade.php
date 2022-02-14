
<div class="text-right">
    @if($bill_copy != null)
    <a class="btn btn-primary btn-sm" data-placement="top" title="Download Bill Copy" href="{{ Storage::disk('public')->url('expense/'.$bill_copy) }}" download>
        <i class="fas fa-download"></i>
    </a>
@endif
    <a class="btn btn-primary btn-sm" data-placement="top" title="Edit Expense" href="{{ route('expenses.edit',$id) }}"><i class="fas fa-edit"></i></a>
    <button type="button" class="btn btn-danger btn-sm" data-placement="top" title="Delete Expense" onclick="deleteData({{ $id }})"><i class="fas fa-trash-alt"></i></button>
    <form id="delete-form-{{ $id }}" action="{{ route('expenses.destroy',$id) }}" method="POST" style="display: none;">
        @csrf()
        @method('DELETE')
    </form>
</div>
