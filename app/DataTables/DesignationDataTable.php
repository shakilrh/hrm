<?php

namespace App\DataTables;

use App\Designation;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class DesignationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable
            ->addColumn('department', function ($query) {
                return isset($query->department->name) ? $query->department->name : 'Not Found';
            })
            ->setRowClass('{{ $status == true ? "text-dark" : "text-danger" }}')
            ->editColumn('status', function ($query) {
                return $query->status == true ? '<span class="badge badge-primary">Active</span>
' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['status', 'action'])
            ->addColumn('modified', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'designation.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Designation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Designation $model)
    {
        return $model->newQuery()->select('id', 'department_id', 'name', 'status', 'updated_at')
            ->orderByDesc('id');
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
                    ->addAction(['width' => '80px'])
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['print', 'pdf', 'excel', 'csv', 'reset', 'reload'],
                        'initComplete' => "function () {
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement(\"input\");
                                $(input).addClass(\"form-control form-control-sm\")
                                $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
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
            'department',
            'name',
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
        return 'Designation_' . date('YmdHis');
    }
}
