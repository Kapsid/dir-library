<?php
namespace DirSync;

use DirSync\helpers\DirectoriesHelper;

/**
 * Class DirSync
 * @package DirSync
 * @author Martin Urbanczyk
 */
class DirSync implements DirSyncInterface{

    /**
     * @var string $rootDir
     */
    public $rootDir;

    /**
     * @var string $srcFilePath
     */
    public $srcFilePath;

    /**
     * @var array $jsonInput
     */
    public $jsonInput;

    /**
     * Constants for options
     */
    const SYNC_CREATE_ONLY = 'SYNC_CREATE_ONLY';
    const SYNC_REMOVE_ONLY = 'SYNC_REMOVE_ONLY';
    const SYNC_ACTIONS_ONLY = 'SYNC_ACTIONS_ONLY';

    /**
     * DirSync constructor.
     */
    public function __construct(){
        $this->rootDir = null;
        $this->srcFilePath = null;
        $this->jsonInput = null;
    }

    /**
     * Setting up root dir
     * @param string $path
     * @return $this|DirSyncInterface
     */
    public function setRootDir($path) : self {
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
    public function fromFile($filePath) : self{
        $this->srcFilePath = $filePath;
        return $this;
    }

    /**
     * Settomg up json stored in an array
     * @throws Exception
     */
    public function setJsonInput() : void {
        $this->jsonInput = $this->getJsonInput();
    }

    /**
     * Setting decoded data
     * @throws \DirSync\Exception
     * @return array Return an array JSON data.
     */
    private function getJsonInput() : array {

        try {
            return json_decode(file_get_contents($this->srcFilePath), true);
        }

        catch (\Exception $e){
            throw new \Exception('Invalid Json');
        }
    }


    /**
     * Beginning process of synchronization
     * @param null $options
     * @return $this
     */
    public function sync($options=null) : self {
        if($this->jsonInput){

            // Checking if root dir is set, otherwise setting actual directory
            if(!isset($this->rootDir)) $this->rootDir = __DIR__;

            if(is_array($options)){
                if(in_array(DirSync::SYNC_ACTIONS_ONLY,$options) === false){
                   // Walkthrough only with actions
                }
                else{
                    // Walkthtough with only adding or only removing passed in parameters
                }
            }

            else{
                // Full sync
                DirectoriesHelper::syncDirectories($this->rootDir, $this->jsonInput, $options);
            }
        }
        return $this;
    }
}