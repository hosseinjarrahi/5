<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBox extends Model
{
    protected $with = [
        'category'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public $timestamps = false;
}
