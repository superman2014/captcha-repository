<?php

namespace Superman2014\CaptchaRepository\Facade;

use Illuminate\Support\Facades\Facade;

class CaptchaRepository extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'captcharepository';
    }
}

