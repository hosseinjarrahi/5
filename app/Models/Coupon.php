<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'extime' => 'datetime'
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function isExpired()
    {
        return $this->extime->lt(now());
    }

    public function ownCode($productId)
    {
        return !$this->products()->where('id',$productId)->get()->isEmpty();
    }

    public function checkCount()
    {
        return $this->count > 0;
    }

    public function valid($productId){
        return !$this->isExpired() && $this->ownCode($productId) && $this->checkCount();
    }
}
