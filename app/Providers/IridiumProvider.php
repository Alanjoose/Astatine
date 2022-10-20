<?php

namespace App\Providers;

/*********************************************************
 * -----------------IRIDIUM PROVIDER-----------------
 * 
 * FLOWCHART:
 * 1 - Dev insert the action.
 * 2 - Dev insert the object.
 * 3- Dev insert the object-name.
 *********************************************************/
class IridiumProvider
{
    protected string $templatesDir;

    public function __construct()
    {
        $this->templatesDir = 'templates/iridium';
    }

    protected function getTemplate(string $object)
    {
        try
        {
            $file = $this->templatesDir . '/' . ucwords($object) . 'Template.php.dist';

            if(!file_exists($file)) {
                throw new \Exception("File not found on {$this->templatesDir} directory.");
            }

            $fileContent = file_get_contents($file);

            return $fileContent;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on get the ' . $object . 'template file.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    protected function routeObjectFileDirectory(string $object)
    {
        try
        {
            switch($object):

            case "model":
            return "app/Models";
            break;

            #TODO: FINALY THIS METHOD FOLLOWING THE OTHERS DEVELOP MODULES.

            default:
            throw new \Exception("Directory inexistent.");
            break;

            endswitch;
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on route the ' . $object . ' directory.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    protected function generateFile(string $object, string $objectName)
    {
        try
        {
          $fileDirectory = $this->routeObjectFileDirectory($object);
          $templateToBeUsed = str_replace("CLASSNAME", ucwords($objectName), $this->getTemplate($object));
          $newFile = $fileDirectory.'/'.ucwords($objectName).'.php';

          if(file_exists($newFile)) {
            throw new \Exception("This file already exists.");
          }

          file_put_contents($newFile, $templateToBeUsed);
          
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on generate the file.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }
}
