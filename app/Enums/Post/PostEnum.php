<?php

namespace App\Enums\Post;

use App\Supports\Enum;
enum PostEnum: int
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
