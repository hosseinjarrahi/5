<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepo
{
    public static function findByCode($coupon)
    {
        return Coupon::where('code', $coupon)->first();
    }
}
