<?php
namespace DirSync;

use Tracy\Debugger;

class DirSync implements DirSyncInterface{

    private $rootDir;
    private $jsonFileContent;
    private $srcFilePath;
    private $jsonInput;
    private $syncState;

    public function __construct(){
        $this->rootDir = null;
        $this->srcFilePath = null;
        $this->jsonInput = null;
        $this->syncState = null;
    }

    /**
     * Will set the root directory in which the directory
     * sync will be applied.
     * If the root directory is not set the Instance should look for
     * constant "__root__"; if the constant is not provided
     * then the root is the system root.
     * @param string $path A valid path to a existing directory
     * @return self
     */
    public function setRootDir($path){
        $this->rootDir = $path;
        return $this;
    }

    /**
     * Will read the JSON string directly from a file path;
     *
     * @param string $filePath A valid json file path
     * @throws \DirSync\Exception
     * @return self
     */
    public function fromFile($filePath){
        $this->srcFilePath = $filePath;
        $this->setJsonInput();
        return $this;
    }

    /**
     * Will provide the library with the JSON input
     *
     * @param string $JSON A raw string JSON
     * @throws \DirSync\Exception
     * @return self
     */
    private function setJsonInput(){
        $this->jsonInput = $this->getJsonInput();
        return $this;
    }

    /**
     * Simply return the previously given JSON data.
     * @throws \DirSync\Exception
     * @return string Return a string JSON data.
     */
    private function getJsonInput(){
        return json_decode(file_get_contents($this->srcFilePath), true);
    }


    /**
     * Will begin the process of the synchronization.
     * The process can have the following options:
     *
     *  \DirSync::SYNC_CREATE_ONLY - creating directories only;<br>
     *  \DirSync::SYNC_REMOVE_ONLY - only removing directories;<br>
     *  \DirSync::SYNC_ACTIONS_ONLY - just run the action but do
     *  not change the directory tree in any way;<br>
     *
     * @param mixed [optional] Additional options for the directory sync process
     * @throws \DirSync\Exception
     * @return self|array
     */
    public function sync($options=null){
        $this->syncState = 'DONE';
        if($this->jsonInput){
            $this->createDirs($this->rootDir, $this->jsonInput);
        }
        return $this;
    }

    /**
     * Function for creating directories on certain location
     * @param $actualDirectory
     * @param $actualArrays
     */
    private function createDirs($actualDirectory, $actualArrays) {
        $actualDirectory .= '/';

        // Load folders in actual dir
        $currentDirs = $this->parseOriginalDirectories(array_filter(glob($actualDirectory.'*'), 'is_dir'));
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
                    $this->createDirs($actualDirectory.$directoryName, $actualArrays[$directoryName]);
                }
            }

            else{
                $subRemoveDirs = $this->parseOriginalDirectories(array_filter(glob($actualDirectory.$actualArrays[$directoryName].$directoryName.'/*'), 'is_dir'));
                $this->removeDirectory($subRemoveDirs,$actualDirectory.$actualArrays[$directoryName].$directoryName,true);
            }



        }

        // Removing unnecesarry dirs
        $this->removeDirectory($currentDirs,$actualDirectory);

    }

    /**
     * Parsing directory names
     * @param $originalArray
     * @return array
     */
    private function parseOriginalDirectories($originalArray){
        $newArray = [];
        foreach($originalArray as $originalValue){
            array_push($newArray,basename($originalValue));
        }

        return $newArray;
    }

    /** Function to remove directories
     * @param $listOfDirectories
     * @param $actualDirectory
     * @param bool $subfolder
     */
    private function removeDirectory($listOfDirectories, $actualDirectory, $subfolder = false){
        if(!empty($listOfDirectories)){
            foreach($listOfDirectories as $unnecessaryDir){


                if( is_dir($actualDirectory.$unnecessaryDir) !== false )
                {
                    if (PHP_OS === 'Windows')
                    {
                        //exec(sprintf("rd /s /q %s/", escapeshellarg($actualDirectory.$actualArrays[$directoryName].$subRemoveDir)));
                    }
                    else
                    {
                        if($subfolder === false){
                            exec(sprintf("rm -rf %s", escapeshellarg($actualDirectory.$unnecessaryDir)));
                        }
                        else{
                            exec(sprintf("rm -rf %s/*", escapeshellarg($actualDirectory.$unnecessaryDir)));
                        }
                    }
                }
            }
        }
    }
}