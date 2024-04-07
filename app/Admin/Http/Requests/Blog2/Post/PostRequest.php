<?php

namespace App\Admin\Http\Requests\Blog2\Post;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Post\PostEnum;
use Illuminate\Validation\Rules\Enum;

class PostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'categories_id' => ['required', 'array'],
            'categories_id.*' => ['required', 'exists:App\Models\Category2,id'],
            'title' => ['required', 'string'],
            'feature_image' => ['nullable'],
            'status' => ['required', new Enum(PostEnum::class)],
            'excerpt' => ['nullable'],
            'content' => ['nullable']
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Post2,id'],
            'categories_id' => ['required', 'array'],
            'categories_id.*' => ['required', 'exists:App\Models\Category,id'],
            'title' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:App\Models\Post2,slug,' . $this->id],
            'feature_image' => ['nullable'],
            'status' => ['required', new Enum(PostEnum::class)],
            'excerpt' => ['nullable'],
            'content' => ['nullable']
        ];
    }
}
