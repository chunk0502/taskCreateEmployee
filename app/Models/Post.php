<?php

namespace App\Models;

use App\Enums\Post\PostEnum;
use App\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'posts';
    protected $guarded = [];
    protected $columnSlug = 'title';

    protected $casts = [
        'status' => PostEnum::class,
    ];

    public function isPublished(){
        return $this->status == PostEnum::Published;
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function scopePublished($query){
        return $query->where('status', PostEnum::Published);
    }

    public function scopeHasCategories($query, array $categoriesId){
        return $query->whereHas('categories', function($query) use($categoriesId) {
            $query->whereIn('id', $categoriesId);
        });
    }
}
