<?php

namespace Tonjoo\HSC\Facade;

use Tonjoo\HSC\Facade\Facade as Facade;

class HSCNoticeFacade extends Facade{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    
     public static function getFacadeAccessor() { 

     	return 'hsc_notice';

     }

}