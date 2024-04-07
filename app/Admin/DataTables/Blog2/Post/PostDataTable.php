<?php

namespace App\Admin\DataTables\Blog2\Post;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category2\CategoryRepositoryInterface;
use App\Admin\Repositories\Post2\PostRepositoryInterface;
use App\Enums\Post\PostEnum;

class PostDataTable extends BaseDataTable
{

    protected $nameTable = 'post2Table';

    protected $repoCat;

    public function __construct(
        PostRepositoryInterface $repository,
        CategoryRepositoryInterface $repoCat
    ){
        $this->repository = $repository;

        $this->repoCat = $repoCat;

        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.blog2.posts.datatable.action',
            'feature_image' => 'admin.blog2.posts.datatable.feature-image',
            'title' => 'admin.blog2.posts.datatable.title',
            'status' => 'admin.blog2.posts.datatable.status',
            'categories' => 'admin.blog2.posts.datatable.categories',
            'checkbox' => 'admin.blog2.posts.datatable.checkbox',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [2, 3, 4, 5];

        $this->columnSearchDate = [5];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => PostEnum::asSelectArray()
            ],
        ];

        $this->columnSearchSelect2 = [
            [
                'column' => 4,
                'data' => $this->repoCat->getFlatTree()->map(function($category){
                    return [$category->id => generate_text_depth_tree($category->depth).$category->name];
                })
            ]
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['categories']);
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.post2', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'feature_image' => $this->view['feature_image'],
            'title' => $this->view['title'],
            'status' => $this->view['status'],
            'categories' => $this->view['categories'],
            'created_at' => '{{ format_date($created_at) }}',
            'checkbox' => $this->view['checkbox'],
        ];
    }
    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'categories' => function($query, $keyword) {
                $query->whereHas('categories', function($q) use($keyword) {
                    $q->whereIn('id', explode(',', $keyword));
                });
            }
        ];
    }
    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['checkbox', 'feature_image', 'title', 'status', 'categories', 'action'];
    }
}
