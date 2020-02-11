<?php


namespace DirSync\helpers;

/**
 * Class DirectoriesHelper
 * @package DirSync\helpers
 * This is a helper class for working with directories
 */
class DirectoriesHelper
{

    /**
     * Removing all directories (or its content) for certain array and path
     * @param $listOfDirectories
     * @param $actualDirectory
     * @param bool $subfolder
     */
    private static function removeDirectory($listOfDirectories, $actualDirectory, $subfolder = false): void{
        if(!empty($listOfDirectories)){
            foreach($listOfDirectories as $unnecessaryDir){
                $fullPathDirectory = $actualDirectory.'/'.$unnecessaryDir;

                if( is_dir($fullPathDirectory) !== false )
                {
                    if (PHP_OS === 'Windows')
                    {
                        //exec(sprintf("rd /s /q %s/", escapeshellarg($actualDirectory.$actualArrays[$directoryName].$subRemoveDir)));
                    }
                    else
                    {
                        if($subfolder === false){
                            exec(sprintf("rm -rf %s", escapeshellarg($fullPathDirectory)));
                        }
                        else{
                            exec(sprintf("rm -rf %s/*", escapeshellarg($fullPathDirectory)));
                        }
                    }
                }
            }
        }
    }


    /**
     * Getting array of directories with only basePath
     * @param $originalArray
     * @return array
     */
    private static function getBasepathDirectoriesArray($originalArray) : array {
        $basePathArray = [];
        foreach($originalArray as $originalValue){
            array_push($basePathArray,basename($originalValue));
        }
        return $basePathArray;
    }


    /**
     * Recursive function for creating directories structure
     * @param $actualDirectory
     * @param $actualArrays
     */
    public static function createDirectories($actualDirectory, $actualArrays) : void {
        $actualDirectory .= '/';

        // Load folders in actual dir
        $currentDirs = self::getBasepathDirectoriesArray(array_filter(glob($actualDirectory.'*'), 'is_dir'));
        sort($currentDirs);
        $jsonDirs = array_keys($actualArrays);
        sort($jsonDirs);

        foreach($jsonDirs as $directoryName){

            if (($key = array_search($directoryName, $currentDirs)) !== false) {
                unset($currentDirs[$key]);
            }

            if( is_dir($actualDirectory.$directoryName) === false )
            {
                mkdir($actualDirectory.$directoryName);
            }


            if(isset($actualArrays[$directoryName])){
                if(is_array($actualArrays[$directoryName])){
                    self::createDirectories($actualDirectory.$directoryName, $actualArrays[$directoryName]);
                }
            }

            else{
                $subRemoveDirs = self::removeDirectory(array_filter(glob($actualDirectory.$actualArrays[$directoryName].$directoryName.'/*'), 'is_dir'));
                self::removeDirectory($subRemoveDirs,$actualDirectory.$actualArrays[$directoryName].$directoryName);
            }

        }

        // Removing unnecesarry dirs
        self::removeDirectory($currentDirs,$actualDirectory);
    }

}