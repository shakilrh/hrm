<?php

namespace App\DataTables;

use App\Payslip;
use App\Enums\PayslipStatus;
use Yajra\DataTables\Services\DataTable;

class PayslipDataTable extends DataTable
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
            ->addColumn('e_code', function ($query) {
                return $query->employee->employee_code ?? 'Not Found';
            })
            ->addColumn('name', function ($query) {
                return $query->employee->user->name ?? 'Not Found';
            })
            ->addColumn('date', function ($query) {
                return $query->date;
            })
            ->addColumn('net_salary', function ($query) {
                return $query->getNetSalary();
            })
            ->addColumn('status', function ($query) {
                return $query->status == PayslipStatus::Paid ?
                    '<span class="badge badge-primary">'
                        .PayslipStatus::getKey($query->status).
                    '</span>'
                    :
                    '<span class="badge badge-danger">'
                        .PayslipStatus::getKey($query->status).
                    '</span>';
            })
            ->addColumn('timestamp', function ($query) {
                return $query->updated_at;
            })
            ->rawColumns(['status', 'action'])
            ->addColumn('action', 'payroll.payslip.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Payslip $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payslip $model)
    {
        return $model->newQuery()->select('id', 'employee_id', 'year', 'month', 'instant_deduction', 'status', 'created_at', 'updated_at')->orderByDesc('id');
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
                        'dom' => 'Bfrtip',
                        'buttons' => ['print', 'pdf', 'excel', 'csv', 'reset', 'reload'],
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
            'e_code',
            'name',
            'month',
            'year',
            'net_salary',
            'status',
            'timestamp'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Payslip_' . date('YmdHis');
    }
}
