<span @class([
    'badge', \App\Enums\Post\PostEnum::from($status)->badge()
])>{{ \App\Enums\Post\PostEnum::from($status)->description() }}</span>
