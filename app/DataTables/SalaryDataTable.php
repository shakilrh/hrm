<?php

namespace App\DataTables;

use App\Employee;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Services\DataTable;

class SalaryDataTable extends DataTable
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
                return $query->employee_code;
            })
            ->addColumn('name', function ($query) {
                return isset($query->user->name) ? $query->user->name : 'Not Found';
            })
            ->addColumn('total_allowance', function ($query) {
                return $query->getTotalAllowances();
            })
            ->addColumn('gross_salary', function ($query) {
                return $query->getGrossSalary();
            })
            ->addColumn('total_deduction', function ($query) {
                return $query->getTotalDeductions();
            })
            ->addColumn('net_salary', function ($query) {
                return $query->getNetSalary();
            })
            ->addColumn('modified', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', function ($query) {
                return '<a class="btn btn-primary btn-sm" href="'.
                        route('payroll.salary.manager.manage', $query->employee_code) .'">
                        <i class="fas fa-tools"></i>
                            <span>Manage</span>
                        </a>';
            })
            ->rawColumns(['image', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
    {
        return $model->newQuery()->select(
            'id',
            'user_id',
            'employee_code',
            'basic_salary',
            'updated_at'
        )->orderByDesc('id');
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
            'basic_salary',
            'total_allowance',
            'gross_salary',
            'total_deduction',
            'net_salary',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Salary_' . date('YmdHis');
    }
}
