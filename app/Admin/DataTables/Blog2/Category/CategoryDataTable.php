<?php

namespace App\Admin\DataTables\Blog2\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category2\CategoryRepositoryInterface;

class CategoryDataTable extends BaseDataTable
{

    protected $nameTable = 'category2Table';

    public function __construct(
        CategoryRepositoryInterface $repository
    ){
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.blog2.categories.datatable.action',
            'name' => 'admin.blog2.categories.datatable.name',
            'status' => 'admin.blog2.categories.datatable.status',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0];

        // $this->columnSearchSelect = [
        //     [
        //         'column' => 1,
        //         'data' => DefaultStatus::asSelectArray()
        //     ],
        // ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PostCategory $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function query()
    {
        $query = $this->repository->getFlatTree();
        return $query;
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.category2', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'status' => $this->view['status'],
            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function startBuilderDataTable($query){
        $this->instanceDataTable = datatables()->collection($query);
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['name', 'status', 'action'];
    }
}
