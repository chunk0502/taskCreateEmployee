<?php

namespace App\Admin\Services\Blog2\Post;

use App\Admin\Repositories\Post2\PostRepositoryInterface;
use App\Enums\Post\PostEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostService implements PostServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(PostRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){

        $this->data = $request->validated();
        $this->data['posted_at'] = now();
        $categoriesId = $this->data['categories_id'];

        unset($this->data['categories_id']);

        DB::beginTransaction();
        try {
            $post = $this->repository->create($this->data);

            $this->repository->attachCategories($post, $categoriesId);


            DB::commit();
            return $post;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return false;
        }
    }

    public function update(Request $request){

        $this->data = $request->validated();

        $categoriesId = $this->data['categories_id'];


        unset($this->data['categories_id']);

        DB::beginTransaction();
        try {
            $post = $this->repository->update($this->data['id'], $this->data);

            $this->repository->syncCategories($post, $categoriesId);


            DB::commit();
            return $post;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return false;
        }
    }

    public function delete($id){

        return $this->repository->delete($id);
    }

    public function actionMultipleRecode(Request $request){

        if(!$request->input('id') || empty($request->input('id'))){
            return false;
        }

        $data = $request->all();

        if($data['action'] == 'delete'){

            foreach($data['id'] as $id){

                $this->delete($id);
            }

            return back()->with('success', __('notifySuccess'));
        }elseif($data['action'] == 'publishedStatus' || $data['action'] == 'draftStatus'){

            $this->repository->updateMultipleBy([
                ['id', 'in', $data['id']]
            ], [
                'status' => $data['action'] == 'publishedStatus' ? PostEnum::Published : PostEnum::Draft
            ]);

            return back()->with('success', __('notifySuccess'));
        }

        return false;
    }
}
