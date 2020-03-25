<?php

namespace App\Models;

use AliBayat\LaravelCategorizable\Categorizable;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Categorizable;

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

    // TODO: addd this method
    public function LastThreeStore($query){
        return $query->where('');
    }
}
