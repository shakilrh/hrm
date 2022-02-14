<?php

namespace App\DataTables;

use App\Notice;
use App\Enums\NoticeStatus;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class NoticeDataTable extends DataTable
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
            ->addColumn('timestamp', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'noticeboard.action');
        } else {
            return datatables($query)
            ->setRowClass(function ($query) {
                return $query->status == NoticeStatus::Published ? 'text-dark' : 'text-danger';
            })
            ->editColumn('status', function ($query) {
                return $query->status == NoticeStatus::Published ?
                    '<span class="badge badge-primary">'
                    . NoticeStatus::getKey($query->status) .
                    '</span>'
                    :
                    '<span class="badge badge-danger">'
                    . NoticeStatus::getKey($query->status) .
                    '</span>';
            })
            ->rawColumns(['status', 'action'])
            ->addColumn('timestamp', function ($query) {
                return $query->updated_at->diffForHumans();
            })
            ->addColumn('action', 'noticeboard.action');
        }
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Notice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Notice $model)
    {
        if (Auth::user()->hasRole('employee')) {
            return $model->newQuery()->select('id', 'title', 'description', 'updated_at')->where('status', NoticeStatus::Published)->orderByDesc('id');
        } else {
            return $model->newQuery()->select('id', 'title', 'description', 'status', 'updated_at')->orderByDesc('id');
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
        if (Auth::user()->hasRole('employee')) {
            return [
            'title',
            'timestamp'
        ];
        } else {
            return [
            'title',
            'status',
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
        return 'Notice_' . date('YmdHis');
    }
}
