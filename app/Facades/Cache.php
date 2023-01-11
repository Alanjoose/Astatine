<?php

namespace App\Facades;

use App\Contracts\Cacheable;
use Exception;

class Cache
{
    use Cacheable;

   public static function new($data, $module)
   {
    return self::generateCacheFile($data, $module);
   }
}
