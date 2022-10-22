<?php

namespace App\Contracts\Iridium;

trait InteractWithModelTemplate
{

    private function getModelTemplateWithClassNameReplaced(string $modelName)
    {
        try
        {
            $template = $this->getModelTemplate();

            return str_replace("CLASSNAME", $this->parseModelFileName($modelName), $template);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on fill the model with your variables.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    private function getModelTemplate()
    {
        try
        {
            $file = "templates/iridium/ModelTemplate.php.dist";

            if(!file_exists($file)) {
                throw new \Exception("Template file not exists.");
            }

            return file_get_contents($file);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on get model file template.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    private function modelFileExists(string $modelName)
    {
        try
        {
            $file = "app/Models/".$this->parseModelFileName($modelName).".php";

            return file_exists($file);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on verify the file existence.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    private function getFilteredAndCapitalizedModelName(string $modelName)
    {
        try
        {
            if((bool) preg_match('/[0-9\@\.\;\" "]+/', $modelName)) {
                $modelNameWithoutSpecialChars = $this->removeSpecialCharsFromModelName($modelName);
                return ucwords(str_replace(" ", "", $modelNameWithoutSpecialChars));
            }
            else if(strpos($modelName, "_")) {
                $modelNameWithoutUnderscores = $this->removeUnderscoresFromModelName($modelName);
                return ucwords(" ", "", $modelNameWithoutUnderscores);
            }
            else if((bool) preg_match('/[0-9\@\.\;\" "]+/', $modelName) && strpos($modelName, "_")) {
                $modelNameWithoutSpecialChars = $this->removeSpecialCharsFromModelName($modelName);
                return str_replace(" ", "", $this->removeUnderscoresFromModelName($modelName));
            }

            return ucwords($modelName);

        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on parse the model name notation.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    private function removeUnderscoresFromModelName(string $modelName)
    {
        try
        {
            return str_replace("_", " ", $modelName);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on remove underscores from model name.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

    private function removeSpecialCharsFromModelName(string $modelName)
    {
        try
        {
            return preg_replace('/[0-9\@\.\;\" "]+/', ' ', $modelName);
        }
        catch(\Exception $exception)
        {
            return [
                'message' => 'Error on remove special chars from model name.',
                'data' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString()
                ]
            ];
        }
    }

}
