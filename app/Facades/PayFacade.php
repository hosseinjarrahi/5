<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PayFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'payFacade';
    }

    public function choose($class){
        app()->singleton(self::getFacadeAccessor(),$class);
    }
}