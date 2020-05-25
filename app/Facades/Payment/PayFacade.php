<?php
namespace App\Facades\Payment;

use Illuminate\Support\Facades\Facade;

class PayFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'PayFacade';
    }

    public static function choose($class){
        app()->singleton(self::getFacadeAccessor(),$class);
    }
}
