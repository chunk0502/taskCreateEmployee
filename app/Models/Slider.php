<?php

namespace App\Models;

use App\Enums\Post\PostEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $guarded = [];

    protected $casts = [
        'status' => PostEnum::class
    ];

    public function items(){
        return $this->hasMany(SliderItem::class, 'slider_id')->orderBy('position', 'asc');
    }

    public function scopePublished($query){
        $query->where('status', PostEnum::Published);
    }
}
