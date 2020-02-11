<?php
namespace DirSync;

use DirSync\helpers\DirectoriesHelper;

class DirSync implements DirSyncInterface{

    public $rootDir;
    private $srcFilePath;
    private $jsonInput;
    private $syncState;

    public function __construct(){
        $this->rootDir = null;
        $this->srcFilePath = null;
        $this->jsonInput = null;
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
     * Will read the JSON string directly from a file path, also setting up parsed json input
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
     * Setting decoded data
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
        if($this->jsonInput){
            DirectoriesHelper::createDirectories($this->rootDir, $this->jsonInput);
        }
        return $this;
    }
}