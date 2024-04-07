<?php

use App\Enums\Admin\AdminRoles;
use App\Enums\Employee\RolesEnum;
use App\Enums\Gender;
use App\Enums\Post\PostEnum;

return [
    AdminRoles::class => [
        AdminRoles::SuperAdmin->value => 'Dev',
        AdminRoles::Admin->value => 'Admin',
    ],
    Gender::class => [
        Gender::Male->value => 'Nam',
        Gender::Female->value => 'Nữ',
        Gender::Other->value => 'Khác',
    ],
    RolesEnum::class => [
        RolesEnum::Admin->value => 'Admin',
        RolesEnum::Dev->value => 'Dev',
        RolesEnum::Other->value => 'Khác',
    ],
    PostEnum::class => [
        PostEnum::Published->value => 'Đã xuất bản',
        PostEnum::Draft->value => 'Bản nháp'
    ]
];


