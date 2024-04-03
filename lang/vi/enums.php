<?php

use App\Enums\Admin\AdminRoles;
use App\Enums\DefaultStatus;
use App\Enums\Gender;
use App\Enums\Employee\RolesEnum;

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
    DefaultStatus::class => [
        DefaultStatus::Published->value => 'Đã xuất bản',
        DefaultStatus::Draft->value => 'Bản nháp'
    ]
];


