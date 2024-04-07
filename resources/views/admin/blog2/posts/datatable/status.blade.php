<span @class([
    'badge',
    \App\Enums\Post\PostEnum::tryFrom($status)->badge()
])>{{ \App\Enums\Post\PostEnum::getDescription($status) }}</span>
