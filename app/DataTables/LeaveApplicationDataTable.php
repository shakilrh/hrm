<?php

namespace App\DataTables;

use App\LeaveApplication;
use App\Enums\LeaveStatus;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class LeaveApplicationDataTable extends DataTable
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
                return $query->status == LeaveStatus::Approved ? 'text-dark' : 'text-danger';
            })
            ->addColumn('employee_name', function ($query) {
                return isset($query->employee->user->name) ? $query->employee->user->name : 'Not Found';
            })
            ->addColumn('e-_code', function ($query) {
                return isset($query->employee->employee_code) ? $query->employee->employee_code : 'Not Found';
            })
            ->addColumn('leave_type', function ($query) {
                return isset($query->type->name) ? $query->type->name : 'Not Found';
            })
            ->editColumn('status', function ($query) {
                return $query->status == LeaveStatus::Approved ?
                    '<span class="badge badge-primary">'
                    . LeaveStatus::getKey($query->status) .
                    '</span>'
                    :
                    '<span class="badge badge-danger">'
                    . LeaveStatus::getKey($query->status) .
                    '</span>';
            })
            ->rawColumns(['status', 'action'])
            ->addColumn('timestamp', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'leave.application.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\LeaveApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LeaveApplication $model)
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
                    ->addAction(['width' => '80px'])
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
            'employee_name',
            'e-_code',
            'leave_type',
            'leave_form',
            'leave_to',
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
        return 'LeaveApplication_' . date('YmdHis');
    }
}
