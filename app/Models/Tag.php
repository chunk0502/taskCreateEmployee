<?php

namespace App\Models;

use App\Enums\Post\PostEnum;
use App\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'tags';

    protected $guarded = [];

    protected $casts = [
        'status' => PostEnum::class,
    ];

    public function isPublished(){
        return $this->status == PostEnum::Published;
    }

    public function scopePublished($query){
        return $query->where('status', PostEnum::Published);
    }
}
