<?php

namespace App\DataTables;

use App\Award;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class AwardDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        if (Auth::user()->hasRole('employee')) {
            return datatables($query)
            ->addColumn('award', function ($query) {
                return isset($query->awardType->name) ? $query->awardType->name : 'Not Found';
            })
            ->editColumn('date', function ($query) {
                return Carbon::parse($query->date)->format('M o');
            });
        } else {
            return datatables($query)
            ->addColumn('employee_name', function ($query) {
                return isset($query->employee->user->name) ? $query->employee->user->name : 'Not Found';
            })
            ->addColumn('e-_code', function ($query) {
                return isset($query->employee->employee_code) ? $query->employee->employee_code : 'Not Found';
            })
            ->addColumn('award', function ($query) {
                return isset($query->awardType->name) ? $query->awardType->name : 'Not Found';
            })
            ->editColumn('date', function ($query) {
                return Carbon::parse($query->date)->format('M o');
            })
            ->addColumn('timestamp', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'award.action');
        }
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Award $model)
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
        if (Auth::user()->hasRole('employee')) {
            return $this->builder()
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->parameters([
                    'dom' => 'Bfrtip',
                    'buttons' => ['print', 'pdf', 'excel', 'csv', 'reset', 'reload'],
                ]);
        } else {
            return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px'])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['print', 'pdf', 'excel', 'csv', 'reset', 'reload'],
                    ]);
        }
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (Auth::user()->hasRole('employee')) {
            return [
                'award',
                'gift_item',
                'cash_price',
                'date',
            ];
        } else {
            return [
                'employee_name',
                'e-_code',
                'award',
                'gift_item',
                'cash_price',
                'date',
                'timestamp'
            ];
        }
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Award_' . date('YmdHis');
    }
}
