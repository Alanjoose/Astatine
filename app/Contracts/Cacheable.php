<?php

namespace App\Contracts;

use Exception;

trait Cacheable
{
    private static function generateCacheFile($data, $module)
    {
       try
       {
            //RETURN EARLY TO THROW EXCEPTION.
            if(!is_array($data)) {
                throw new Exception("The data must be an array.");
            }

            //GENERATING CACHE FILE CONTENT.
            $cacheTemplate = "<?php\n";
            foreach($data as $key => $value) {

                if(is_string($value)) {
                    $cacheTemplate.="\$$key = '$value';\n";
                }
                else if($value === true) {
                    $cacheTemplate.="\$$key = true;\n";
                }
                else if($value === false) {
                    $cacheTemplate.="\$$key = false;\n";
                }
                else if(is_array($value)) {
                    $cacheTemplate.="\$$key = '$value';";
                }
                else {
                    $cacheTemplate.="\$$key = $value;\n";
                }
            }
            $cacheTemplate.="?>\n";

            $fileName = $module.uniqid("_mem_")."_cache.php";
            $completeFileDir = storagePath("cache/$module/$fileName");

            if(file_exists($completeFileDir)) {
                file_put_contents($completeFileDir, $cacheTemplate, FILE_APPEND);
            }
            else {
                file_put_contents($completeFileDir, $cacheTemplate);
            }
       }
       catch(Exception $exception)
       {
            echo $exception->getMessage();
       }
    }
}
