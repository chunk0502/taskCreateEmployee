<?php

namespace App\Admin\Http\Controllers\Blog2\Category;

use App\Admin\DataTables\Blog2\Category\CategoryDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Blog2\Category\CategoryRequest;
use App\Admin\Repositories\Category2\CategoryRepositoryInterface;
use App\Admin\Services\Blog2\Category\CategoryServiceInterface;
use App\Enums\Post\PostEnum;

class CategoryController extends Controller
{
    public function __construct(
        CategoryRepositoryInterface $repository,
        CategoryServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){

        return [
            'index' => 'admin.blog2.categories.index',
            'create' => 'admin.blog2.categories.create',
            'edit' => 'admin.blog2.categories.edit'
        ];
    }

    public function getRoute(){

        return [
            'index' => 'admin.blog2.category.index',
            'create' => 'admin.blog2.category.create',
            'edit' => 'admin.blog2.category.edit',
            'delete' => 'admin.blog2.category.delete'
        ];
    }
    public function index(CategoryDataTable $dataTable){

        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('blog'))->add(__('category'))
        ]);
    }

    public function create(){

        $categories = $this->repository->getFlatTree();

        return view($this->view['create'], [
            'categories' => $categories,
            'status' => PostEnum::asSelectArray(),
            'breadcrums' => $this->crums->add(__('blog'))->add(__('category'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(CategoryRequest $request){

        $response = $this->service->store($request);

        if($response){
            return $request->input('submitter') == 'save'
                    ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                    : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id){

        $categories = $this->repository->getFlatTreeNotInNode([$id]);

        $category = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'category' => $category,
                'categories' => $categories,
                'status' => PostEnum::asSelectArray(),
                'breadcrums' => $this->crums->add(__('blog'))->add(__('category'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(CategoryRequest $request){

        $response = $this->service->update($request);

        if($response){
            return $request->input('submitter') == 'save'
                    ? back()->with('success', __('notifySuccess'))
                    : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }

    public function delete($id){

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
