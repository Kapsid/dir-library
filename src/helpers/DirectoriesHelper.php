<?php

namespace DirSync\helpers;

use DirSync\DirSync;
use Tracy\Debugger;

/**
 * Class DirectoriesHelper
 * @package DirSync\helpers
 * This is a helper class for working with directories
 * @author Martin Urbanczyk
 */
class DirectoriesHelper
{

    /**
     * Removing all directories (or its content) for certain array and path
     * @param $listOfDirectories
     * @param $actualDirectory
     * @param bool $subfolder
     */
    private static function removeDirectory($listOfDirectories, $actualDirectory = false, $subfolder = false): void{
        if(!empty($listOfDirectories)){
            foreach($listOfDirectories as $unnecessaryDir){
                if($actualDirectory === true){
                    $fullPathDirectory = $unnecessaryDir;
                }
                else{
                    $fullPathDirectory = $actualDirectory.'/'.$unnecessaryDir;
                }

                Debugger::barDump($fullPathDirectory,"full path");

                if( is_dir($fullPathDirectory) !== false )
                {
                    if (PHP_OS === 'Windows')
                    {
                        //exec(sprintf("rd /s /q %s/", escapeshellarg($actualDirectory.$actualJsonArray[$directoryName].$subRemoveDir)));
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
     * This function should be much simples (e.g. the whole process of going through json dirs should be in another function)
     * @param $actualDirectory
     * @param $actualJsonArray Json passed in DirSync init
     */
    public static function syncDirectories($actualDirectory, $actualJsonArray, $options = false) : void {

        // Adding slash to actual dir
        $actualDirectory .= '/';

        // Load folders in actual dir
        $currentDirs = self::getBasepathDirectoriesArray(array_filter(glob($actualDirectory.'*'), 'is_dir'));

        // Sorting for later comparison
        sort($currentDirs);

        $jsonDirs = array_keys(ActionsHelper::parseActions($actualJsonArray));


        // Sorting for later comparison
        sort($jsonDirs);

        // Going through all filtered directories in json
        foreach($jsonDirs as $directoryName){

            // If this dir is already created remove it from currents dirs
            if (($key = array_search($directoryName, $currentDirs)) !== false) {
                unset($currentDirs[$key]);
            }

            if( is_dir($actualDirectory.$directoryName) === false )
            {
                // There should be a check if there are not any banned characters that can be in the folder
                mkdir($actualDirectory.$directoryName);
            }


            if(isset($actualJsonArray[$directoryName])){
                if(is_array($actualJsonArray[$directoryName])){
                    self::syncDirectories($actualDirectory.$directoryName, $actualJsonArray[$directoryName]);
                }
            }

            else{
                $subRemoveDirs = array_filter(glob($actualDirectory.$actualJsonArray[$directoryName].$directoryName.'/*'), 'is_dir');
                self::removeDirectory($subRemoveDirs);
            }

        }


        // Removing unnecesarry dirs in this level
        self::removeDirectory($currentDirs,$actualDirectory);
    }

}