<?php

namespace App\DataTables;

use App\Employee;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
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
                return $query->user->status == UserStatus::Active ? 'text-dark' : 'text-danger';
            })
            ->addColumn('image', function ($query) {
                return '<div class="text-center">
                            <img src="'. Storage::disk('public')->url('users/'.$query->user->image).'" class="avatar" alt="profile image">
                        </div>';
            })
            ->addColumn('e-code', function ($query) {
                return $query->employee_code;
            })
            ->addColumn('name', function ($query) {
                return isset($query->user->name) ? $query->user->name : 'Not Found';
            })
            ->addColumn('branch', function ($query) {
                return isset($query->branch->name) ? $query->branch->name : 'Not Found';
            })
            ->addColumn('department', function ($query) {
                return isset($query->department->name) ? $query->department->name : 'Not Found';
            })
            ->addColumn('designation', function ($query) {
                return isset($query->designation->name) ? $query->designation->name : 'Not Found';
            })
            /* ->addColumn('basic_salary', function ($query) {
                return $query->basic_salary;
            }) */
            ->addColumn('status', function ($query) {
                return $query->user->status == UserStatus::Active ?
                    '<span class="badge badge-primary">'
                        .UserStatus::getKey($query->user->status).
                    '</span>'
                    :
                    '<span class="badge badge-danger">'
                        .UserStatus::getKey($query->user->status).
                    '</span>';
            })
            ->rawColumns(['image','status', 'action'])
            ->addColumn('modified', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'employee.action');
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
            'branch_id',
            'department_id',
            'designation_id',
            'employee_code',
            'basic_salary',
            'updated_at'
        )
            ->orderByDesc('id')->with('user');
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
            'image',
            'e-code',
            'name',
            'branch',
            'department',
            'designation',
            'basic_salary',
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
        return 'Employee_' . date('YmdHis');
    }
}
