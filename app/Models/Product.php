<?php

namespace App\Models;

use AliBayat\LaravelCategorizable\Categorizable;
use AliBayat\LaravelCategorizable\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Categorizable;
    protected $with = [
        'categories'
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'course_items' => 'Array',
        'meta' => 'Array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

    public static function lastThreeProductWith($subject){
        
        $category = Category::where('name',$subject)->first();
        return $category->entries(self::class)->orderByDesc('id')->limit('3')->get();
    }

}
