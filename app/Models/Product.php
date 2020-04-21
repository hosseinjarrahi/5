<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Taggable;

    protected $with = [
        'categories',
        'user'
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
    
    public function coupon()
    {
        return $this->hasMany(Coupon::class);
    }

    public function files()
    {
        return $this->morphMany(File::class,'fileable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public static function lastThreeProductWith(Category $category){
        
        return $category->entries(self::class)->orderByDesc('id')->limit('3')->get();
    }

    public static function randomByCategory($category)
    {
        $category = Category::where('slug',$category)->firstOrFail();
        return $category->products()->inRandomOrder()->limit(3)->get();
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'model','categories_models');
    }

}
