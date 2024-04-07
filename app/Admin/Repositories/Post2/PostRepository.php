<?php

namespace App\Admin\Repositories\Post2;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Post2\PostRepositoryInterface;
use App\Models\Post2;

class PostRepository extends EloquentRepository implements PostRepositoryInterface
{

    public function getModel()
    {
        return Post2::class;
    }

    public function updateMultipleBy(array $filter = [], array $data)
    {

        $this->instance = $this->model;

        $this->applyFilters($filter);

        $this->instance = $this->instance->update($data);
        return $this->instance;
    }

    public function attachCategories(Post2 $post, array $categoriesId)
    {
        return $post->categories()->attach($categoriesId);
    }



    public function syncCategories(Post2 $post, array $categoriesId)
    {
        return $post->categories()->sync($categoriesId);
    }


}
