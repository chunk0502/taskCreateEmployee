<?php

namespace App\Admin\Repositories\Post2;
use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Models\Post2;

interface PostRepositoryInterface extends EloquentRepositoryInterface
{
    public function updateMultipleBy(array $filter = [], array $data);
    public function attachCategories(Post2 $post, array $categoriesId);
    public function syncCategories(Post2 $post, array $categoriesId);
}
