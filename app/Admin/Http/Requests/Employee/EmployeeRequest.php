<?php
namespace App\Admin\Http\Requests\Employee;
use App\Admin\Http\Requests\BaseRequest;
use Couchbase\Role;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Gender;
use App\Enums\Employee\RolesEnum;
class EmployeeRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'username' => [
                'required',
                'string', 'min:6', 'max:50',
                'unique:App\Models\Employee,username',
                'regex:/^[A-Za-z0-9_-]+$/',
                function ($attribute, $value, $fail) {
                    if (in_array(strtolower($value), ['admin', 'user',
                        'password'])) {
                        $fail('The ' . $attribute . ' cannot be a common
keyword.');
                    }
                },
            ],
            'email' => ['required', 'email', 'unique:App\Models\Employee,email'],
            'gender' => ['required', new Enum(Gender::class)],
            'roles' => ['required', new Enum(RolesEnum::class)],
            'date' => ['required', 'date_format:Y-m-d'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }
    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Employee,id'],
            'username' => [
                'required',
                'string', 'min:6', 'max:50',
                'unique:App\Models\Employee,username,' . $this->id,
                'regex:/^[A-Za-z0-9_-]+$/',
                function ($attribute, $value, $fail) {
                    if (in_array(strtolower($value), ['admin', 'user',
                        'password'])) {
                        $fail('The ' . $attribute . ' cannot be a common
keyword.');
                    }
                },
            ],
            'email' => ['required', 'email', 'unique:App\Models\Employee,email,' .
                $this->id],
            'gender' => ['required', new Enum(Gender::class)],
            'roles' => ['required', new Enum(RolesEnum::class)],
            'date' => ['required', 'date_format:Y-m-d'],
            'password' => ['nullable', 'string', 'confirmed'],
        ];
    }
}
