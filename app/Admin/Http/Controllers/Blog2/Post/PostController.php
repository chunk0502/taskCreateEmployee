<?php

namespace App\Admin\Http\Controllers\Blog2\Post;

use App\Admin\DataTables\Blog2\Post\PostDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Blog2\Post\PostRequest;
use App\Admin\Repositories\Category2\CategoryRepositoryInterface;
use App\Admin\Repositories\Post2\PostRepositoryInterface;
use App\Admin\Services\Blog2\Post\PostServiceInterface;
use App\Enums\Post\PostEnum;
use Illuminate\Http\Request;

class  PostController extends Controller
{
    protected $repoCat;

    protected $repoTag;

    public function __construct(
        PostRepositoryInterface $repository,
        CategoryRepositoryInterface $repoCat,
        PostServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;
        $this->repoCat = $repoCat;
        $this->service = $service;
    }

    public function getView(){

        return [
            'index' => 'admin.blog2.posts.index',
            'create' => 'admin.blog2.posts.create',
            'edit' => 'admin.blog2.posts.edit'
        ];
    }

    public function getRoute(){

        return [
            'index' => 'admin.blog2.post.index',
            'create' => 'admin.blog2.post.create',
            'edit' => 'admin.blog2.post.edit',
            'delete' => 'admin.blog2.post.delete'
        ];
    }
    public function index(PostDataTable $dataTable){

        $actionMultiple = [
            'delete' => trans('delete'),
            'publishedStatus' => PostEnum::Published->description(),
            'draftStatus' => PostEnum::Draft->description()
        ];

        return $dataTable->render($this->view['index'], [
            'actionMultiple' => $actionMultiple,
            'breadcrums' => $this->crums->add(__('blog'))->add(__('post'))
        ]);
    }

    public function create(){

        $categories = $this->repoCat->getFlatTree();

        return view($this->view['create'], [
            'categories' => $categories,
            'status' => PostEnum::asSelectArray(),
            'breadcrums' => $this->crums->add(__('blog'))->add(__('post'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(PostRequest $request){

        $response = $this->service->store($request);

        if($response){
            return $request->input('submitter') == 'save'
                    ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                    : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id){

        $categories = $this->repoCat->getFlatTree();

        $post = $this->repository->findOrFail($id, ['categories', 'tags']);

        return view(
            $this->view['edit'],
            [
                'categories' => $categories,
                'post' => $post,
                'status' => PostEnum::asSelectArray(),
                'breadcrums' => $this->crums->add(__('blog'))->add(__('post'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(PostRequest $request){

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

    public function actionMultipleRecode(Request $request){

        $response = $this->service->actionMultipleRecode($request);

        if($response){

            return $response;
        }

        return back()->with('error', __('notifyFail'));
    }
}
