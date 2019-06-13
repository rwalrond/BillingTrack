<?php

namespace FI\DataTables;

use FI\Modules\Vendors\Models\Vendor;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class VendorsDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'vendors._actions')
            ->editColumn('id', function (Vendor $vendor) {
                return '<input type="checkbox" class="bulk-record" data-id="'. $vendor->id .'">';
            })
            ->editColumn('name', function (Vendor $vendor) {
                return '<a href="/vendors/' . $vendor->id . '">' . $vendor->name . '</a>';
            })
            ->rawColumns(['name', 'action', 'id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \FI\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vendor $model)
    {
        $models = $model->newQuery()->getSelect()
                        ->leftJoin('vendors_custom', 'vendors_custom.vendor_id', '=', 'vendors.id')
                        ->with(['currency'])
                        ->status(request('status'));

        return $models;

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
                    //->parameters($this->getBuilderParameters());
                    ->parameters(['order' => [1, 'asc']]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' =>
                ['name' => 'id',
                 'data' => 'id',
                 'orderable' => false,
                 'searchable' => false,
                 'printable' => false,
                 'exportable' => false,
                 'class'=>'bulk-record',
            ],
            'name' => [
                'title' => trans('fi.vendor_name'),
                'data' => 'name',
            ],
            'email' => [
                'title' => trans('fi.email_address'),
                'data' => 'email',
            ],
            'phone' => [
                'title' => trans('fi.phone_number'),
                'data' => 'phone',
            ],
//            'balance' => [
//                'name' => 'balance',
//                'title' => trans('fi.balance'),
//                'data' => 'formatted_balance',
//                'orderable' => true,
//                'searchable' => false,
//            ],
            'active' => [
                'title' => trans('fi.active'),
                'data' => 'active',
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Vendors_' . date('YmdHis');
    }
}
