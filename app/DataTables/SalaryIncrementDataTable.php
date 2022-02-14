<?php

namespace App\DataTables;

use App\SalaryIncrement;
use Yajra\DataTables\Services\DataTable;

class SalaryIncrementDataTable extends DataTable
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
            ->addColumn('e-code', function ($query) {
                return $query->employee->employee_code ?? 'Not Found';
            })
            ->addColumn('name', function ($query) {
                return $query->employee->user->name ?? 'Not Found';
            })
            ->addColumn('date', function ($query) {
                return $query->updated_at->toDateString();
            })
            ->addColumn('action', function ($query) {
                return '<a class="btn btn-primary btn-sm" href="'.
                        route('payroll.salary.manager.manage', $query->employee->employee_code ?? '') .'">
                        <i class="fas fa-tools"></i>
                            <span>Manage</span>
                        </a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\SalaryIncrement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SalaryIncrement $model)
    {
        return $model->newQuery()->select('id', 'employee_id', 'amount', 'remark', 'updated_at');
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
                    ->addAction(['width' => '130px'])
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
            'e-code',
            'name',
            'amount',
            'date'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SalaryIncrement_' . date('YmdHis');
    }
}
