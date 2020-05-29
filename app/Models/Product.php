<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Product extends Model
{
    use Taggable;
    use HasTrixRichText;

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

    public function payments()
    {
        return $this->morphMany(Payment::class,'model');
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
        return $category->products()->orderByDesc('id')->limit('3')->get();
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

    public function getMeta()
    {
        $value = $this->meta;
        $value['keywords'] = collect($value['keywords'])->implode(',');
        return $value;
    }
}
