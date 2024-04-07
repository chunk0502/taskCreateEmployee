<?php

namespace App\Admin\Http\Requests\Blog2\Category;

use App\Admin\Http\Requests\BaseRequest;
use App\Admin\Rules\Category\CategoryParent;
use App\Enums\Post\PostEnum;
use Illuminate\Validation\Rules\Enum;

class CategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:App\Models\Category2,id'],
            'position' => ['required', 'integer'],
            'status' => ['required', new Enum(PostEnum::class)]
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Category2,id'],
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:App\Models\Category2,slug,'.$this->id],
            'parent_id' => ['nullable', 'exists:App\Models\Category2,id', new CategoryParent($this->id)],
            'position' => ['nullable', 'integer'],
            'status' => ['required', new Enum(PostEnum::class)]
        ];
    }
}
