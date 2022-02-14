<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\AttendanceData;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class AttendanceDataDataTable extends DataTable
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
            ->addColumn('date', function ($query) {
                return Carbon::parse($query->attendance->date)->format('d M o');
            })
            ->addColumn('status', 'attendance.status')
            ->rawColumns(['status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\AttendanceData $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AttendanceData $model)
    {
        return $model->newQuery()
        /* ->with('attendance')->get()
        ->sortBy(function ($model) {
            return $model->attendance->orderBy('id', 'desc');
        }) */
        ->where('employee_id', Auth::user()->employee->id)->orderByDesc('id');
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
            'status',
            'remark'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AttendanceData_' . date('YmdHis');
    }
}
