<?php

namespace App\Models;

use App\Enums\Post\PostEnum;
use App\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait, Sluggable;

    protected $table = 'categories';

    protected $guarded = [];

    protected $casts = [
        'status' => PostEnum::class
    ];

    public function posts(){
        return $this->belongsToMany(Post::class, 'categories_posts', 'category_id', 'post_id');
    }

    public function scopePublished($query){
        return $query->where('status', PostEnum::Published);
    }
}
