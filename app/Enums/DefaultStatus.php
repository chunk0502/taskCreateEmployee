<?php

namespace App\Enums;

use App\Enums\Post\PostEnum;
use App\Supports\Enum;

enum DefaultStatus: int
{
    use Enum;

    case Published = 1;
    case Draft = 2;

    public function badge(){
        return match($this) {
            PostEnum::Published => 'bg-green',
            PostEnum::Draft => '',
        };
    }
}
