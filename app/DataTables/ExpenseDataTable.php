<?php

namespace App\DataTables;

use App\Expense;
use App\Enums\ExpenseStatus;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class ExpenseDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->setRowClass(function ($query) {
                return $query->status == ExpenseStatus::Approved ? 'text-dark' : 'text-danger';
            })
            ->editColumn('item_name', function ($query) {
                return str_limit($query->item_name, 20);
            })
            ->addColumn('purchase_by', function ($query) {
                return $query->employee->user->name ?? 'Not Found';
            })
            ->editColumn('status', function ($query) {
                return $query->status == ExpenseStatus::Approved ?
                    '<span class="badge badge-primary">'
                        .ExpenseStatus::getKey($query->status).
                    '</span>'
                    :
                    '<span class="badge badge-danger">'
                        .ExpenseStatus::getKey($query->status).
                    '</span>';
            })
            ->rawColumns(['status', 'action'])
            ->addColumn('modified', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'expense.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Expense $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Expense $model)
    {
        if (Auth::user()->hasRole('employee')) {
            return $model->newQuery()->where('employee_id', Auth::user()->employee->id)->orderByDesc('id');
        } else {
            return $model->newQuery()->orderByDesc('id');
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '110px'])
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['print', 'pdf', 'excel', 'csv', 'reset', 'reload'],
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'item_name',
            'purchase_from',
            'purchase_date',
            'purchase_by',
            'amount',
            'status',
            'modified'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Expense_' . date('YmdHis');
    }
}
