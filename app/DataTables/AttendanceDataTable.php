<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Attendance;
use App\Enums\AttendanceOption;
use Yajra\DataTables\Services\DataTable;

class AttendanceDataTable extends DataTable
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
            ->editColumn('date', function ($query) {
                return Carbon::parse($query->date)->format('d M o');
            })
            ->addColumn('present', function ($query) {
                return  '<span class="badge badge-primary">'.$query->data->where('status', AttendanceOption::Present)->count().'</span>';
            })
            ->addColumn('absence', function ($query) {
                return  '<span class="badge badge-danger">'.$query->data->where('status', AttendanceOption::Absence)->count().'</span>';
            })
            ->addColumn('leave', function ($query) {
                return '<span class="badge badge-warning">' . $query->data->where('status', AttendanceOption::Leave)->count() . '</span>';
            })
            ->addColumn('total', function ($query) {
                return '<span class="badge badge-info">'.$query->data->count().'</span>';
            })
            ->addColumn('timestamp', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->rawColumns(['present','absence','leave','total','action'])
            ->addColumn('action', 'attendance.table-action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Attendance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Attendance $model)
    {
        return $model->newQuery()->select('id', 'date', 'updated_at')->OrderByDesc('date');
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
                    ->addAction(['width' => '100px'])
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
            'date',
            'present',
            'absence',
            'leave',
            'total',
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
        return 'Attendance_' . date('YmdHis');
    }
}
