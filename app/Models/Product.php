<?php

namespace App\Models;

use AliBayat\LaravelCategorizable\Categorizable;
use AliBayat\LaravelCategorizable\Category;
use Illuminate\Database\Eloquent\Model;
use \Spatie\Tags\HasTags;

class Product extends Model
{
    use Categorizable;
    use HasTags;

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

    public static function lastThreeProductWith(Category $category){
        
        return $category->entries(self::class)->orderByDesc('id')->limit('3')->get();
    }

    public static function randomByCategory($category)
    {
        $category = Category::where('slug',$category)->firstOrFail();
        return $category->entries(self::class)->inRandomOrder()->limit(3)->get();
    }
}
